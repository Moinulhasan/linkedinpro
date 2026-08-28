<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop flex flex-col items-center text-center mt-stack-lg mb-24">
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-surface-container-high text-primary font-label-caps text-label-caps mb-8 border border-outline-variant/30">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
        </span>
        Introducing LinkAudit Pro 2.0
    </div>
    <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface max-w-3xl mb-6">
        Elevate Your Professional Identity with <span class="text-primary">Precision</span>.
    </h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-12">
        The most advanced diagnostic tool for premium networkers. Upload your LinkedIn profile PDF export for instant, data-driven optimization insights.
    </p>

    @auth
        @php $remaining = auth()->user()->remainingAnalyses(); @endphp

        @if ($remaining > 0)
            <div class="w-full max-w-2xl glass-panel ambient-shadow rounded-2xl p-2 relative group overflow-hidden">
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_2s_infinite]"></div>
                <form id="analyze-form" action="{{ route('profile-audits.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-2 relative z-10">
                    @csrf
                    <div class="relative flex-grow flex items-center bg-surface-container-lowest/50 rounded-xl px-4 py-3 border border-outline-variant/30 opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-outline mr-3">link</span>
                        <input class="w-full bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline-variant p-0 cursor-not-allowed" placeholder="Paste LinkedIn Profile URL... (Coming Soon)" type="url" disabled>
                    </div>
                    <input type="file" name="pdf" id="pdf-input" accept="application/pdf" class="hidden">
                    <button id="pdf-trigger" class="flex-shrink-0 flex items-center justify-center gap-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-body-md text-body-md px-6 py-3 rounded-xl transition-colors border border-outline-variant/30" type="button">
                        <span class="material-symbols-outlined">upload_file</span>
                        <span class="hidden sm:inline" id="pdf-label">Upload PDF</span>
                    </button>
                    <button id="analyze-submit" class="flex-shrink-0 bg-primary hover:bg-surface-tint text-on-primary font-body-md text-body-md font-semibold px-8 py-3 rounded-xl transition-all shadow-md active:scale-95 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" type="submit" disabled>
                        Analyze
                        <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
                    </button>
                </form>
                <p id="analyze-error" class="hidden text-error text-sm mt-3 relative z-10"></p>
            </div>
            <div class="mt-6 text-on-surface-variant/70 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">lock</span>
                {{ $remaining }} of {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses remaining. PDF must be exported from LinkedIn ("Save to PDF") for best results.
            </div>
        @else
            <div class="w-full max-w-2xl glass-panel ambient-shadow rounded-2xl p-stack-lg">
                <p class="text-on-surface font-semibold mb-2">You've used all {{ \App\Models\User::FREE_ANALYSIS_LIMIT }} free analyses.</p>
                <a href="{{ route('dashboard') }}" class="text-primary hover:underline">View your past reports</a>
            </div>
        @endif
    @else
        <div class="w-full max-w-2xl glass-panel ambient-shadow rounded-2xl p-stack-lg flex flex-col items-center gap-4">
            <p class="text-on-surface font-semibold">Sign in to run your free profile analysis.</p>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="bg-surface-container-high hover:bg-surface-container-highest text-on-surface px-6 py-2.5 rounded-lg transition-colors border border-outline-variant/30">Sign In</a>
                <a href="{{ route('register') }}" class="bg-primary hover:bg-surface-tint text-on-primary px-6 py-2.5 rounded-lg transition-all shadow-md">Sign Up Free</a>
            </div>
        </div>
    @endauth

    <div id="analyze-overlay" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-on-surface text-surface-bright">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none flex justify-center items-center">
            <div class="w-[800px] h-[800px] bg-primary/10 rounded-full blur-[120px] absolute opacity-50"></div>
            <div class="w-[400px] h-[400px] bg-primary-fixed-dim/10 rounded-full blur-[80px] absolute translate-x-1/2 translate-y-1/2"></div>
        </div>
        <x-processing-panel />
    </div>
</section>
