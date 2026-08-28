<nav class="fixed top-0 w-full bg-surface/80 backdrop-blur-xl border-b border-white/10 shadow-sm transition-all duration-200 z-50">
    <div class="flex items-center justify-between h-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <a href="{{ route('welcome') }}" class="font-display-lg text-headline-md tracking-tighter text-on-surface flex items-center gap-2 transition-all duration-200 active:scale-95">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">analytics</span>
            LinkAudit Pro
        </a>

        <div class="flex items-center gap-stack-md font-body-md text-body-md">
            @auth
                <a href="{{ route('dashboard') }}" class="text-on-surface-variant hover:text-primary transition-colors">My Analyses</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-on-surface-variant hover:text-primary transition-colors">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-on-surface-variant hover:text-primary transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="bg-primary hover:bg-surface-tint text-on-primary px-5 py-2 rounded-lg transition-all shadow-sm">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>
