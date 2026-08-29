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
<body class="bg-background text-on-surface min-h-screen font-body-md text-body-md relative overflow-x-hidden selection:bg-primary-container selection:text-on-primary-container">
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary-fixed-dim/20 blur-[120px] mix-blend-multiply opacity-70"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-surface-container-highest/30 blur-[150px] mix-blend-multiply opacity-50"></div>
    </div>

    @yield('content')

    @guest
        <x-modal name="login" focusable>
            <div class="glass-panel ambient-shadow p-stack-lg relative">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'login' }))" class="absolute top-5 right-5 text-on-surface-variant hover:text-on-surface transition-colors focus:outline-none">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="text-center mb-stack-lg">
                    <h2 class="font-display-lg-mobile text-display-lg-mobile text-on-surface mb-2">Welcome Back</h2>
                    <p class="text-on-surface-variant text-sm">Continue auditing your LinkedIn profile</p>
                </div>
                @include('auth.partials.login-form')
            </div>
        </x-modal>

        <x-modal name="register" focusable>
            <div class="glass-panel ambient-shadow p-stack-lg relative">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'register' }))" class="absolute top-5 right-5 text-on-surface-variant hover:text-on-surface transition-colors focus:outline-none">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="text-center mb-stack-lg">
                    <h2 class="font-display-lg-mobile text-display-lg-mobile text-on-surface mb-2">Join LinkAudit Pro</h2>
                    <p class="text-on-surface-variant text-sm">Get your free recruiter &amp; ATS-readiness audit</p>
                </div>
                @include('auth.partials.register-form')
            </div>
        </x-modal>

        @php
            $reopenModal = session('auth_modal')
                ?? ($errors->has('name') || $errors->has('password_confirmation') ? 'register' : ($errors->any() ? 'login' : null));
        @endphp
        @if ($reopenModal)
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: '{{ $reopenModal }}' }));
                });
            </script>
        @endif
    @endguest
</body>
</html>
