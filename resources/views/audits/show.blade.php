<x-app-layout title="Feedback Report - LinkAudit Pro">
    @php
        $circumference = 339.292;
        $score = $audit->score ?? 0;
        $offset = $circumference * (1 - $score / 100);
        $scoreColor = match (true) {
            $score >= 70 => '#16a34a',
            $score >= 40 => '#d97706',
            default => '#ba1a1a',
        };
        $statusStyles = [
            'green' => ['bg-green-100', 'text-green-700'],
            'amber' => ['bg-amber-100', 'text-amber-700'],
            'red' => ['bg-error-container', 'text-on-error-container'],
        ];
    @endphp

    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors text-sm mb-stack-md">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Back to Dashboard
    </a>

    <header class="mb-stack-lg flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-2">Feedback Report</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Your comprehensive LinkedIn profile diagnosis.</p>
        </div>
        <button onclick="window.print()" class="bg-gradient-to-r from-primary to-primary-fixed-dim text-on-primary px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all shadow-md flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined">download</span>
            Export PDF Report
        </button>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-lg md:col-span-4 flex flex-col items-center justify-center text-center h-full min-h-[300px]">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md w-full text-left">Profile Strength</h2>
            <div class="relative w-48 h-48 flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" fill="none" r="54" stroke="#e5eeff" stroke-width="8"></circle>
                    <circle class="progress-ring__circle" cx="60" cy="60" fill="none" r="54" stroke="{{ $scoreColor }}" stroke-width="8" stroke-linecap="round"
                            stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"></circle>
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="font-display-lg text-display-lg" style="color: {{ $scoreColor }}">{{ $score }}</span>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">/ 100</span>
                </div>
            </div>
            <p class="mt-stack-sm font-body-md text-body-md text-on-surface-variant">{{ $audit->verdict }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-lg md:col-span-8 flex flex-col">
            <div class="flex items-center gap-3 mb-stack-md">
                <div class="w-10 h-10 rounded-xl bg-primary-container/15 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                </div>
                <h2 class="font-headline-md text-headline-md text-on-surface">AI Recommendations</h2>
            </div>
            <ul class="space-y-3 flex-1">
                @foreach ($audit->recommendations ?? [] as $rec)
                    <li class="flex items-start gap-3 p-4 bg-surface-container-lowest rounded-xl border border-outline-variant/20">
                        <div class="w-8 h-8 rounded-lg {{ $rec['severity'] === 'success' ? 'bg-green-100' : 'bg-amber-100' }} flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-lg {{ $rec['severity'] === 'success' ? 'text-green-700' : 'text-amber-700' }}">
                                {{ $rec['severity'] === 'success' ? 'check_circle' : 'warning' }}
                            </span>
                        </div>
                        <div>
                            <h4 class="font-mono-data text-mono-data text-on-surface mb-1">{{ $rec['title'] }}</h4>
                            <p class="font-body-md text-body-md text-on-surface-variant text-sm">{{ $rec['description'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if (!empty($audit->sections))
            <div class="md:col-span-12 mt-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Section Breakdown</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    @foreach ($audit->sections as $section)
                        @php $style = $statusStyles[$section['status']] ?? $statusStyles['amber']; @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-md flex flex-col hover:shadow-lg transition-shadow duration-300">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-mono-data text-mono-data text-on-surface">{{ $section['name'] }}</h3>
                                <div class="{{ $style[0] }} {{ $style[1] }} px-2 py-1 rounded-full font-label-caps text-label-caps flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">circle</span> {{ ucfirst($section['status']) }}
                                </div>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-4 flex-1">{{ $section['summary'] }}</p>
                            <div class="bg-surface-container py-2 px-3 rounded-lg text-sm text-on-surface">
                                <span class="font-semibold">Tip:</span> {{ $section['tip'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="md:col-span-12 mt-stack-lg">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Full Report</h2>
            <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-lg audit-report">
                {!! Illuminate\Support\Str::markdown($audit->result) !!}
            </div>
        </div>
    </div>
</x-app-layout>
