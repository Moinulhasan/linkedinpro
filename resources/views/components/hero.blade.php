<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-stack-lg mb-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="flex flex-col items-center lg:items-start text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-surface-container-high text-primary font-label-caps text-label-caps mb-8 border border-outline-variant/30">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                Free AI-Powered LinkedIn Audit
            </div>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface max-w-xl mb-6">
                Is Your LinkedIn Profile <span class="text-primary">Recruiter-Ready?</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-10">
                Upload your LinkedIn PDF export and our AI audits it like a recruiter and an ATS scanner would &mdash;
                scoring your profile strength and handing you a clear, step-by-step plan to fix what's holding you back.
            </p>

            @auth
                @php $remaining = auth()->user()->remainingAnalyses(); @endphp

                @if ($remaining > 0)
                    <div class="w-full max-w-xl">
                        <x-upload-form />
                    </div>
                    <div class="mt-6 text-on-surface-variant/70 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        {{ $remaining }} of {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses remaining. PDF must be exported from LinkedIn ("Save to PDF").
                    </div>
                @else
                    <div class="w-full max-w-xl glass-panel ambient-shadow rounded-2xl p-stack-lg">
                        <p class="text-on-surface font-semibold mb-2">You've used all {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses.</p>
                        <a href="{{ route('dashboard') }}" class="text-primary hover:underline">View your past reports</a>
                    </div>
                @endif
            @else
                <div class="w-full max-w-xl glass-panel ambient-shadow rounded-2xl p-stack-lg flex flex-col items-center gap-4">
                    <p class="text-on-surface font-semibold">Sign in, then upload your PDF &mdash; that's it.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('login') }}" class="bg-surface-container-high hover:bg-surface-container-highest text-on-surface px-6 py-2.5 rounded-lg transition-colors border border-outline-variant/30">Sign In</a>
                        <a href="{{ route('register') }}" class="bg-primary hover:bg-surface-tint text-on-primary px-6 py-2.5 rounded-lg transition-all shadow-md">Sign Up Free</a>
                    </div>
                </div>
            @endauth
        </div>

        <div class="hidden lg:flex justify-center">
            <div class="glass-panel ambient-shadow rounded-2xl p-stack-lg w-full max-w-sm rotate-2">
                <div class="flex items-center justify-between mb-stack-md">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">Sample Report</span>
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                </div>
                <div class="flex flex-col items-center text-center py-4">
                    <div class="relative w-32 h-32 flex items-center justify-center mb-4">
                        <svg class="w-full h-full" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" fill="none" r="54" stroke="#e5eeff" stroke-width="8"></circle>
                            <circle cx="60" cy="60" fill="none" r="54" stroke="#005d8f" stroke-width="8" stroke-linecap="round"
                                    stroke-dasharray="339.292" stroke-dashoffset="67.858"
                                    style="transform: rotate(-90deg); transform-origin: 50% 50%;"></circle>
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="font-display-lg text-headline-md text-primary">80</span>
                            <span class="font-label-caps text-label-caps text-on-surface-variant">/ 100</span>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-sm">Strong foundation, minor tweaks needed.</p>
                </div>
                <div class="space-y-2 mt-2">
                    <div class="flex items-center gap-2 bg-surface-container-lowest/60 rounded-lg px-3 py-2 text-sm">
                        <span class="material-symbols-outlined text-amber-500 text-base">warning</span>
                        <span class="text-on-surface-variant">Headline lacks specific keywords</span>
                    </div>
                    <div class="flex items-center gap-2 bg-surface-container-lowest/60 rounded-lg px-3 py-2 text-sm">
                        <span class="material-symbols-outlined text-green-600 text-base">check_circle</span>
                        <span class="text-on-surface-variant">About section is highly engaging</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-analyze-overlay />
</section>
