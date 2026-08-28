<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LinkAudit Pro')</title>
    @vite([
        'resources/css/app.css',
        'resources/css/home.css',
        'resources/css/audits.css',
        'resources/js/app.js',
        'resources/js/home.js',
        'resources/js/audits.js',
    ])
</head>
<body class="text-on-surface font-body-md dashboard-bg">
    <nav class="hidden md:flex bg-surface/80 backdrop-blur-xl fixed top-0 w-full border-b border-white/10 shadow-sm justify-between items-center h-20 px-margin-desktop max-w-container-max mx-auto z-50">
        <div class="font-display-lg text-headline-md tracking-tighter text-on-surface font-bold">
            LinkAudit Pro
        </div>
    </nav>

    <div class="flex h-screen pt-20 max-w-[1440px] mx-auto">
        <aside class="hidden md:flex bg-surface-container-low/90 backdrop-blur-2xl h-[calc(100vh-80px)] w-72 left-0 top-20 border-r border-outline-variant/30 shadow-md flex-col py-stack-lg px-stack-md fixed">
            <div class="mb-stack-lg flex items-center gap-4 px-4">
                <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-primary font-bold">
                    {{ collect(explode(' ', auth()->user()->name))->map(fn ($n) => $n[0])->take(2)->join('') }}
                </div>
                <div>
                    <h3 class="font-headline-md text-body-md text-on-surface">{{ auth()->user()->name }}</h3>
                    <p class="font-label-caps text-label-caps text-on-surface-variant">Free Member</p>
                </div>
            </div>

            <nav class="flex-1 flex flex-col gap-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-caps text-label-caps transition-all {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-caps text-label-caps transition-all {{ request()->routeIs('profile-audits.show') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    Profile Analysis
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg font-label-caps text-label-caps">
                    <span class="material-symbols-outlined">group</span>
                    Network Growth
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-caps text-label-caps transition-all {{ request()->routeIs('profile.edit') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">settings</span>
                    Settings
                </a>
            </nav>

            <div class="mt-auto flex flex-col gap-4">
                <button type="button" class="w-full bg-surface-container-high text-primary border border-primary-container py-3 rounded-lg font-label-caps text-label-caps hover:bg-surface-container-highest transition-colors shadow-sm">
                    Upgrade to Executive
                </button>
                <div class="border-t border-outline-variant/30 pt-4 flex flex-col gap-2">
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg font-label-caps text-label-caps">
                        <span class="material-symbols-outlined">help</span>
                        Help Center
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg font-label-caps text-label-caps">
                            <span class="material-symbols-outlined">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 md:ml-72 p-margin-mobile md:p-margin-desktop overflow-y-auto w-full">
            @yield('content')
            <div class="h-24 md:hidden"></div>
        </main>
    </div>
</body>
</html>
