@extends('layouts.dashboard')

@section('title', 'Feedback Report - LinkAudit Pro')

@section('content')
    @php
        $circumference = 339.292;
        $score = $audit->score ?? 0;
        $offset = $circumference * (1 - $score / 100);
        $statusStyles = [
            'green' => ['bg-green-100', 'text-green-800'],
            'amber' => ['bg-amber-100', 'text-amber-800'],
            'red' => ['bg-error-container', 'text-on-error-container'],
        ];
    @endphp

    <header class="mb-stack-lg flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-2">Feedback Report</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Your comprehensive LinkedIn profile diagnosis.</p>
        </div>
        <button onclick="window.print()" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-label-caps text-label-caps hover:bg-on-primary-fixed-variant transition-colors shadow-sm flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined">download</span>
            Export PDF Report
        </button>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <div class="glass-card rounded-xl p-stack-lg md:col-span-4 flex flex-col items-center justify-center text-center h-full min-h-[300px]">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md w-full text-left">Profile Strength</h2>
            <div class="relative w-48 h-48 flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" fill="none" r="54" stroke="#e5eeff" stroke-width="8"></circle>
                    <circle class="progress-ring__circle" cx="60" cy="60" fill="none" r="54" stroke="#005d8f" stroke-width="8" stroke-linecap="round"
                            stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"></circle>
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="font-display-lg text-display-lg text-primary">{{ $score }}</span>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">/ 100</span>
                </div>
            </div>
            <p class="mt-stack-sm font-body-md text-body-md text-on-surface-variant">{{ $audit->verdict }}</p>
        </div>

        <div class="glass-card rounded-xl p-stack-lg md:col-span-8 flex flex-col">
            <div class="flex items-center gap-2 mb-stack-md">
                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">AI Recommendations</h2>
            </div>
            <ul class="space-y-4 flex-1">
                @foreach ($audit->recommendations ?? [] as $rec)
                    <li class="flex items-start gap-3 p-4 bg-surface-container-lowest rounded-lg border border-outline-variant/30">
                        <span class="material-symbols-outlined mt-1 {{ $rec['severity'] === 'success' ? 'text-green-600' : 'text-amber-500' }}">
                            {{ $rec['severity'] === 'success' ? 'check_circle' : 'warning' }}
                        </span>
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
                        <div class="glass-card rounded-xl p-stack-md flex flex-col">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-mono-data text-mono-data text-on-surface">{{ $section['name'] }}</h3>
                                <div class="{{ $style[0] }} {{ $style[1] }} px-2 py-1 rounded-full font-label-caps text-label-caps flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">circle</span> {{ ucfirst($section['status']) }}
                                </div>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-4 flex-1">{{ $section['summary'] }}</p>
                            <div class="bg-surface-container py-2 px-3 rounded text-sm text-on-surface">
                                <span class="font-semibold">Tip:</span> {{ $section['tip'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="md:col-span-12 mt-stack-lg glass-card rounded-xl p-stack-lg flex flex-col md:flex-row items-center justify-between gap-6 border border-primary/20 bg-gradient-to-r from-surface-container-low to-surface-container">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Want Deeper Insights?</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Upgrade to Executive for advanced network analysis, competitor benchmarking, and full PDF exports.</p>
            </div>
            <button type="button" class="bg-primary text-on-primary px-8 py-4 rounded-lg font-label-caps text-label-caps hover:bg-on-primary-fixed-variant transition-colors shadow-md whitespace-nowrap">
                Upgrade to Executive
            </button>
        </div>

        <div class="md:col-span-12 mt-stack-lg">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Full Report</h2>
            <div class="glass-card rounded-xl p-stack-lg audit-report">
                {!! Illuminate\Support\Str::markdown($audit->result) !!}
            </div>
        </div>
    </div>
@endsection
