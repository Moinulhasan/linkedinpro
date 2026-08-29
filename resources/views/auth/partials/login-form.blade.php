<x-auth-session-status class="mb-4 text-center" :status="session('status')" />

<a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center gap-2 bg-surface-container-lowest border border-outline-variant/40 rounded-xl py-3 text-sm font-medium text-on-surface hover:bg-surface-container-low transition-colors mb-5">
    <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
    Sign in with Google
</a>

<div class="flex items-center gap-3 mb-5">
    <div class="flex-1 h-px bg-outline-variant/40"></div>
    <span class="text-xs font-semibold tracking-wider text-on-surface-variant">OR CONTINUE WITH</span>
    <div class="flex-1 h-px bg-outline-variant/40"></div>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="relative mb-3">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">mail</span>
        <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
               placeholder="Email address"
               class="w-full bg-surface-container-lowest border border-outline-variant/40 rounded-xl pl-12 pr-4 py-3 text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary transition-colors">
        @error('email')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="relative mb-3">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">lock</span>
        <input id="login-password" type="password" name="password" required autocomplete="current-password"
               placeholder="Password"
               class="w-full bg-surface-container-lowest border border-outline-variant/40 rounded-xl pl-12 pr-4 py-3 text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary transition-colors">
        @error('password')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between mb-5 text-sm">
        <label for="remember_me" class="inline-flex items-center gap-2 text-on-surface-variant">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-outline-variant text-primary focus:ring-primary">
            <span class="tracking-wide">Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-primary hover:underline">Forgot?</a>
    </div>

    <button type="submit" class="w-full bg-primary hover:bg-surface-tint text-on-primary font-semibold py-3 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
        Sign In
        <span class="material-symbols-outlined text-lg">arrow_forward</span>
    </button>
</form>

<p class="text-center text-sm text-on-surface-variant mt-6">
    Don't have an account?
    <button type="button" class="text-primary font-semibold hover:underline"
            onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'login' })); window.dispatchEvent(new CustomEvent('open-modal', { detail: 'register' }))">
        Sign up for free
    </button>
</p>
