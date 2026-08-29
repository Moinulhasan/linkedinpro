<x-app-layout title="Dashboard - LinkAudit Pro">
    @php
        $completed = $audits->where('status', 'completed');
        $avgScore = $completed->isNotEmpty() ? round($completed->avg('score')) : null;
        $latest = $audits->first();
        $remaining = auth()->user()->remainingAnalyses();
        $usedCount = $audits->where('status', '!=', 'failed')->count();

        $scoreColor = match (true) {
            $avgScore === null => ['bg-surface-container-high', 'text-on-surface-variant'],
            $avgScore >= 70 => ['bg-green-100', 'text-green-700'],
            $avgScore >= 40 => ['bg-amber-100', 'text-amber-700'],
            default => ['bg-error-container', 'text-on-error-container'],
        };

        $statusColor = match ($latest->status ?? null) {
            'completed' => ['bg-green-100', 'text-green-700'],
            'failed' => ['bg-error-container', 'text-on-error-container'],
            'processing', 'pending' => ['bg-amber-100', 'text-amber-700'],
            default => ['bg-surface-container-high', 'text-on-surface-variant'],
        };
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter mb-gutter">
        <div class="bg-white rounded-2xl p-stack-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-outline-variant/10">
            <div class="w-12 h-12 rounded-xl bg-primary-container/15 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-2xl">description</span>
            </div>
            <div class="font-display-lg text-display-lg text-on-surface leading-none mb-1">{{ $usedCount }}<span class="text-on-surface-variant text-headline-md font-body-md"> / {{ \App\Models\User::FREE_ANALYSIS_LIMIT }}</span></div>
            <div class="font-label-caps text-label-caps text-on-surface-variant tracking-wider">Analyses Used</div>
        </div>

        <div class="bg-white rounded-2xl p-stack-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-outline-variant/10">
            <div class="w-12 h-12 rounded-xl {{ $scoreColor[0] }} flex items-center justify-center mb-4">
                <span class="material-symbols-outlined {{ $scoreColor[1] }} text-2xl">insights</span>
            </div>
            <div class="font-display-lg text-display-lg text-on-surface leading-none mb-1">{{ $avgScore ?? '—' }}</div>
            <div class="font-label-caps text-label-caps text-on-surface-variant tracking-wider">Average Score</div>
        </div>

        <div class="bg-white rounded-2xl p-stack-lg shadow-sm hover:shadow-lg transition-shadow duration-300 border border-outline-variant/10">
            <div class="w-12 h-12 rounded-xl {{ $statusColor[0] }} flex items-center justify-center mb-4">
                <span class="material-symbols-outlined {{ $statusColor[1] }} text-2xl">bolt</span>
            </div>
            <div class="font-display-lg text-display-lg text-on-surface leading-none mb-1 capitalize">{{ $latest->status ?? 'None' }}</div>
            <div class="font-label-caps text-label-caps text-on-surface-variant tracking-wider">Latest Status</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant/10">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Recent Activity</h2>
                <p class="text-on-surface-variant text-sm mt-0.5">Your latest profile audits</p>
            </div>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'new-analysis' }))" class="bg-gradient-to-r from-primary to-primary-fixed-dim hover:shadow-lg text-on-primary px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                New Analysis
            </button>
        </div>

        @if ($audits->isEmpty())
            <div class="flex flex-col items-center text-center py-16 px-6">
                <div class="w-20 h-20 rounded-full bg-primary-container/15 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-primary text-4xl">description</span>
                </div>
                <h3 class="text-on-surface font-semibold text-lg mb-1">No analyses yet</h3>
                <p class="text-on-surface-variant text-sm mb-6 max-w-xs">Upload your LinkedIn PDF export to get your first recruiter &amp; ATS-readiness audit.</p>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'new-analysis' }))" class="bg-gradient-to-r from-primary to-primary-fixed-dim hover:shadow-lg text-on-primary px-6 py-3 rounded-xl font-semibold transition-all shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Start Your First Analysis
                </button>
            </div>
        @else
            <div class="divide-y divide-outline-variant/10">
                @foreach ($audits as $audit)
                    @php
                        $rowBadge = match ($audit->status) {
                            'completed' => ['bg-green-100', 'text-green-700', 'Completed'],
                            'failed' => ['bg-error-container', 'text-on-error-container', 'Failed'],
                            default => ['bg-amber-100', 'text-amber-700', 'Processing'],
                        };
                    @endphp
                    <a href="{{ $audit->isCompleted() ? route('profile-audits.show', $audit) : route('profile-audits.processing', $audit) }}"
                       class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-surface-container-lowest/60 transition-colors group">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-11 h-11 rounded-xl {{ $rowBadge[0] }} flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined {{ $rowBadge[1] }}">description</span>
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-on-surface truncate group-hover:text-primary transition-colors">{{ $audit->original_filename }}</div>
                                <div class="text-sm text-on-surface-variant">{{ $audit->created_at->format('M j, Y g:ia') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            @if ($audit->isCompleted() && $audit->score !== null)
                                <span class="font-display-lg text-headline-md text-primary">{{ $audit->score }}</span>
                            @endif
                            <span class="px-3 py-1 rounded-full font-label-caps text-label-caps {{ $rowBadge[0] }} {{ $rowBadge[1] }}">
                                {{ $rowBadge[2] }}
                            </span>
                            <span class="material-symbols-outlined text-on-surface-variant/40 group-hover:text-primary transition-colors">chevron_right</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <x-modal name="new-analysis" focusable maxWidth="md">
        <div class="bg-white p-stack-lg relative">
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'new-analysis' }))" class="absolute top-5 right-5 text-on-surface-variant hover:text-on-surface transition-colors focus:outline-none">
                <span class="material-symbols-outlined">close</span>
            </button>

            @if ($remaining > 0)
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 rounded-xl bg-primary-container/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">upload_file</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md text-on-surface">New Analysis</h2>
                </div>
                <p class="text-on-surface-variant text-sm mb-stack-md">Upload your LinkedIn PDF export to get started.</p>
                <x-upload-form />
                <p class="text-on-surface-variant/70 text-sm mt-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    {{ $remaining }} of {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses remaining.
                </p>
            @else
                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">No analyses remaining</h2>
                <p class="text-on-surface-variant">You've used all {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses.</p>
            @endif
        </div>
    </x-modal>

    <x-analyze-overlay />

    @if (session('pending_status_url'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.getElementById('analyze-overlay').classList.remove('hidden');
                window.pollAuditStatus(@json(session('pending_status_url')));
            });
        </script>
    @endif
</x-app-layout>
