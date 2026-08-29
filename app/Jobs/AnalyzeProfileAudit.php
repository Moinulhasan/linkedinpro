<?php

namespace App\Jobs;

use App\Models\ProfileAudit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Throwable;

class AnalyzeProfileAudit implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public function __construct(public ProfileAudit $audit)
    {
    }

    public function handle(): void
    {
        $this->audit->update(['status' => 'processing']);

        $provider = config('services.ai_provider', 'gemini');
        $start = microtime(true);

        try {
            $resumeText = (new Parser())
                ->parseFile(Storage::disk('local')->path($this->audit->pdf_path))
                ->getText();

            if (trim($resumeText) === '') {
                throw new \RuntimeException('Could not extract any text from the uploaded PDF.');
            }

            $analysis = $this->askAI($provider, $resumeText);

            $this->audit->update([
                'status' => 'completed',
                'result' => $analysis['report_markdown'] ?? '',
                'score' => $analysis['score'] ?? null,
                'verdict' => $analysis['verdict'] ?? null,
                'recommendations' => $analysis['recommendations'] ?? [],
                'sections' => $analysis['sections'] ?? [],
            ]);

            Log::info('Profile audit analysis succeeded', [
                'audit_uuid' => $this->audit->uuid,
                'provider' => $provider,
                'duration_seconds' => round(microtime(true) - $start, 2),
            ]);
        } catch (ConnectionException $e) {
            $this->fail($e, $provider, $start, sprintf(
                '%s did not respond in time (timed out after %ds). Try again, or switch AI_PROVIDER in .env.',
                ucfirst($provider),
                180
            ));
        } catch (RequestException $e) {
            $this->fail($e, $provider, $start, sprintf(
                '%s API returned an error (HTTP %d): %s',
                ucfirst($provider),
                $e->response->status(),
                str($e->response->body())->limit(300)
            ));
        } catch (Throwable $e) {
            $this->fail($e, $provider, $start, $e->getMessage());
        } finally {
            Storage::disk('local')->delete($this->audit->pdf_path);
        }
    }

    private function fail(Throwable $e, string $provider, float $start, string $userMessage): void
    {
        $duration = round(microtime(true) - $start, 2);

        Log::error('Profile audit analysis failed', [
            'audit_uuid' => $this->audit->uuid,
            'provider' => $provider,
            'duration_seconds' => $duration,
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        $this->audit->update([
            'status' => 'failed',
            'error' => $userMessage,
        ]);
    }

    private function askAI(string $provider, string $resumeText): array
    {
        return match ($provider) {
            'groq' => $this->askGroq($resumeText),
            default => $this->askGemini($resumeText),
        };
    }

    private function buildInstructions(string $resumeText): string
    {
        $masterPromptFile = file_get_contents(base_path('master/linkedin-profile-audit-prompt.md'));
        preg_match('/```\n(.*?)```/s', $masterPromptFile, $matches);
        $masterPrompt = trim($matches[1] ?? $masterPromptFile);

        return $masterPrompt
            ."\n\nReturn your entire response as a single JSON object with exactly these keys: "
            ."`score` (your overall profile strength score, 0-100, integer), "
            ."`verdict` (one short sentence summarizing the profile's current state), "
            ."`recommendations` (array of 3-4 objects, each with `severity` either \"success\" or \"warning\", `title`, and `description`), "
            ."`sections` (array of 3-4 objects breaking down major profile sections e.g. Headline, About, Experience, Skills, each with "
            ."`name`, `status` either \"green\", \"amber\", or \"red\", `summary`, and `tip`), "
            ."and `report_markdown` (a string containing the FULL audit exactly as specified above, all numbered sections, in Markdown). "
            ."Return only the JSON object, no other text."
            ."\n\nHere is the LinkedIn profile to audit:\n\n".$resumeText;
    }

    private function askGemini(string $resumeText): array
    {
        $instructions = $this->buildInstructions($resumeText);

        $model = config('services.gemini.model');
        $key = config('services.gemini.key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $response = Http::timeout(300)
            ->withHeaders([
                'x-goog-api-key' => $key,
                'Content-Type' => 'application/json',
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $instructions],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'responseSchema' => [
                        'type' => 'OBJECT',
                        'properties' => [
                            'score' => ['type' => 'INTEGER'],
                            'verdict' => ['type' => 'STRING'],
                            'recommendations' => [
                                'type' => 'ARRAY',
                                'items' => [
                                    'type' => 'OBJECT',
                                    'properties' => [
                                        'severity' => ['type' => 'STRING', 'enum' => ['success', 'warning']],
                                        'title' => ['type' => 'STRING'],
                                        'description' => ['type' => 'STRING'],
                                    ],
                                    'required' => ['severity', 'title', 'description'],
                                ],
                            ],
                            'sections' => [
                                'type' => 'ARRAY',
                                'items' => [
                                    'type' => 'OBJECT',
                                    'properties' => [
                                        'name' => ['type' => 'STRING'],
                                        'status' => ['type' => 'STRING', 'enum' => ['green', 'amber', 'red']],
                                        'summary' => ['type' => 'STRING'],
                                        'tip' => ['type' => 'STRING'],
                                    ],
                                    'required' => ['name', 'status', 'summary', 'tip'],
                                ],
                            ],
                            'report_markdown' => ['type' => 'STRING'],
                        ],
                        'required' => ['score', 'verdict', 'recommendations', 'sections', 'report_markdown'],
                    ],
                ],
            ])
            ->throw();

        $text = $response->json('candidates.0.content.parts.0.text') ?? '{}';

        return json_decode($text, true) ?? [];
    }

    private function askGroq(string $resumeText): array
    {
        $instructions = $this->buildInstructions($resumeText);

        $model = config('services.groq.model');
        $key = config('services.groq.key');

        $response = Http::timeout(300)
            ->withToken($key)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $instructions],
                ],
                'response_format' => ['type' => 'json_object'],
            ])
            ->throw();

        $text = $response->json('choices.0.message.content') ?? '{}';

        return json_decode($text, true) ?? [];
    }
}
