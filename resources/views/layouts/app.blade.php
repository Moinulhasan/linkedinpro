@props(['title' => 'LinkAudit Pro'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LinkAudit Pro' }}</title>
    @vite([
        'resources/css/app.css',
        'resources/css/home.css',
        'resources/css/audits.css',
        'resources/js/app.js',
        'resources/js/home.js',
        'resources/js/audits.js',
    ])
</head>
<body class="text-on-surface font-body-md text-body-md antialiased dashboard-bg">
    <div class="lg:flex lg:min-h-screen">
        <aside class="w-full lg:w-72 lg:flex-shrink-0 bg-surface/90 backdrop-blur-xl border-b lg:border-b-0 lg:border-r border-outline-variant/20 lg:fixed lg:inset-y-0 lg:left-0 lg:overflow-y-auto shadow-sm lg:shadow-none">
            <div class="flex items-center justify-between lg:block px-6 py-5">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 font-display-lg text-headline-md tracking-tighter text-on-surface">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    LinkAudit Pro
                </a>

                <div class="lg:hidden">
                    <x-dropdown align="right" width="w-56">
                        <x-slot name="trigger">
                            <button type="button" class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primary-fixed-dim flex items-center justify-center text-on-primary font-semibold hover:opacity-90 transition-opacity shadow-md">
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
                </div>
            </div>

            <div class="hidden lg:flex flex-col items-center text-center px-6 pb-6">
                <div class="relative mb-3">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-primary-fixed-dim flex items-center justify-center text-on-primary font-display-lg text-headline-md shadow-lg ring-4 ring-white">
                        {{ collect(explode(' ', auth()->user()->name))->map(fn ($n) => $n[0])->take(2)->join('') }}
                    </div>
                    <span class="absolute bottom-0 right-0 w-5 h-5 rounded-full bg-green-500 ring-2 ring-white"></span>
                </div>
                <h2 class="text-on-surface font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-on-surface-variant text-sm mb-3 truncate max-w-full">{{ auth()->user()->email }}</p>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full font-label-caps text-label-caps bg-primary-container/15 text-primary border border-primary/20">
                    <span class="material-symbols-outlined text-sm">bolt</span>
                    Free Plan
                </span>
            </div>

            <div class="hidden lg:block mx-6 border-t border-outline-variant/20"></div>

            <nav class="hidden lg:flex flex-col gap-1 px-4 py-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('dashboard') || request()->routeIs('profile-audits.*') ? 'bg-gradient-to-r from-primary to-primary-fixed-dim text-on-primary shadow-md' : 'text-on-surface-variant hover:bg-surface-container-lowest' }}">
                    <span class="material-symbols-outlined text-xl" @if(request()->routeIs('dashboard') || request()->routeIs('profile-audits.*')) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
                    My Analyses
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-gradient-to-r from-primary to-primary-fixed-dim text-on-primary shadow-md' : 'text-on-surface-variant hover:bg-surface-container-lowest' }}">
                    <span class="material-symbols-outlined text-xl" @if(request()->routeIs('profile.edit')) style="font-variation-settings: 'FILL' 1;" @endif>settings</span>
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium text-on-surface-variant hover:bg-surface-container-lowest transition-colors">
                        <span class="material-symbols-outlined text-xl">logout</span>
                        Sign Out
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 lg:ml-72 p-margin-mobile md:p-margin-desktop">
            @isset($header)
                <div class="mb-stack-lg">{{ $header }}</div>
            @endisset

            {{ $slot }}
        </main>
    </div>
</body>
</html>
