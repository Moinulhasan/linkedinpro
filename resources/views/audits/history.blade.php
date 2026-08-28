@extends('layouts.dashboard')

@section('title', 'Dashboard - LinkAudit Pro')

@section('content')
    <header class="mb-stack-lg flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-2">Dashboard</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">
                {{ auth()->user()->remainingAnalyses() }} of {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses remaining.
            </p>
        </div>
        <a href="{{ route('welcome') }}" class="bg-primary hover:bg-surface-tint text-on-primary px-6 py-3 rounded-lg transition-all shadow-sm w-fit">
            New Analysis
        </a>
    </header>

    @if ($audits->isEmpty())
        <div class="glass-card rounded-xl p-stack-lg text-center text-on-surface-variant">
            You haven't run any analyses yet.
        </div>
    @else
        <div class="glass-card rounded-xl divide-y divide-outline-variant/20 overflow-hidden">
            @foreach ($audits as $audit)
                <a href="{{ $audit->isCompleted() ? route('profile-audits.show', $audit) : route('profile-audits.processing', $audit) }}"
                   class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-surface-container-lowest/60 transition-colors">
                    <div class="flex items-center gap-4 min-w-0">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <div class="min-w-0">
                            <div class="font-mono-data text-mono-data text-on-surface truncate">{{ $audit->original_filename }}</div>
                            <div class="text-sm text-on-surface-variant">{{ $audit->created_at->format('M j, Y g:ia') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        @if ($audit->isCompleted() && $audit->score !== null)
                            <span class="font-display-lg text-headline-md text-primary">{{ $audit->score }}</span>
                        @endif
                        @php
                            $badge = match ($audit->status) {
                                'completed' => ['bg-green-100', 'text-green-800', 'Completed'],
                                'failed' => ['bg-error-container', 'text-on-error-container', 'Failed'],
                                default => ['bg-amber-100', 'text-amber-800', 'Processing'],
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full font-label-caps text-label-caps {{ $badge[0] }} {{ $badge[1] }}">
                            {{ $badge[2] }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
