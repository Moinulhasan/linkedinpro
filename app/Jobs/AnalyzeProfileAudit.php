<?php

namespace App\Jobs;

use App\Models\ProfileAudit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
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

        try {
            $resumeText = (new Parser())
                ->parseFile(Storage::disk('local')->path($this->audit->pdf_path))
                ->getText();

            if (trim($resumeText) === '') {
                throw new \RuntimeException('Could not extract any text from the uploaded PDF.');
            }

            $analysis = $this->askGemini($resumeText);

            $this->audit->update([
                'status' => 'completed',
                'result' => $analysis['report_markdown'] ?? '',
                'score' => $analysis['score'] ?? null,
                'verdict' => $analysis['verdict'] ?? null,
                'recommendations' => $analysis['recommendations'] ?? [],
                'sections' => $analysis['sections'] ?? [],
            ]);
        } catch (Throwable $e) {
            $this->audit->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        } finally {
            Storage::disk('local')->delete($this->audit->pdf_path);
        }
    }

    private function askGemini(string $resumeText): array
    {
        $masterPromptFile = file_get_contents(base_path('master/linkedin-profile-audit-prompt.md'));
        preg_match('/```\n(.*?)```/s', $masterPromptFile, $matches);
        $masterPrompt = trim($matches[1] ?? $masterPromptFile);

        $instructions = $masterPrompt
            ."\n\nReturn your entire response as JSON matching the response schema. "
            ."`report_markdown` must contain the FULL audit exactly as specified above (all numbered sections, in Markdown). "
            ."`score` is your overall profile strength score (0-100). `verdict` is one short sentence summarizing the profile's "
            ."current state. `recommendations` are the 3-4 most important AI recommendations (mix of \"warning\" and \"success\" severity). "
            ."`sections` breaks down 3-4 major profile sections (e.g. Headline, About, Experience, Skills) each with a green/amber/red status, "
            ."a one-sentence summary, and a one-sentence actionable tip."
            ."\n\nHere is the LinkedIn profile to audit:\n\n".$resumeText;

        $model = config('services.gemini.model');
        $key = config('services.gemini.key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $response = Http::timeout(180)
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
}
