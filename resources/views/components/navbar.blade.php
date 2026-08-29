<nav class="fixed top-0 w-full bg-surface/80 backdrop-blur-xl border-b border-white/10 shadow-sm transition-all duration-200 z-50">
    <div class="flex items-center justify-between h-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <a href="{{ route('welcome') }}" class="font-display-lg text-headline-md tracking-tighter text-on-surface flex items-center gap-2 transition-all duration-200 active:scale-95">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">analytics</span>
            LinkAudit Pro
        </a>

        <div class="flex items-center gap-stack-md font-body-md text-body-md">
            @guest
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'login' }))" class="bg-primary hover:bg-surface-tint text-on-primary px-5 py-2 rounded-lg transition-all shadow-sm">Sign In</button>
            @else
                <x-dropdown align="right" width="w-56">
                    <x-slot name="trigger">
                        <button type="button" class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary font-semibold hover:opacity-90 transition-opacity flex-shrink-0">
                            {{ collect(explode(' ', auth()->user()->name))->map(fn ($n) => $n[0])->take(2)->join('') }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <a href="{{ route('dashboard') }}" class="block w-full px-4 py-2.5 text-start text-sm whitespace-nowrap text-on-surface-variant hover:bg-surface-container-lowest transition-colors">My Analyses</a>
                        <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2.5 text-start text-sm whitespace-nowrap text-on-surface-variant hover:bg-surface-container-lowest transition-colors">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2.5 text-start text-sm whitespace-nowrap text-on-surface-variant hover:bg-surface-container-lowest transition-colors">Sign Out</button>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endguest
        </div>
    </div>
</nav>
