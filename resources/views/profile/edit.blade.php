<x-app-layout title="Settings - LinkAudit Pro">
    <x-slot name="header">
        <h1 class="font-display-lg-mobile text-display-lg-mobile text-on-surface">Settings</h1>
        <p class="text-on-surface-variant mt-1">Manage your account and security preferences.</p>
    </x-slot>

    <div class="space-y-gutter max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-lg">
            <div class="flex items-center gap-3 mb-stack-md">
                <div class="w-10 h-10 rounded-xl bg-primary-container/15 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">person</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Profile Information</h2>
                </div>
            </div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/10 p-stack-lg">
            <div class="flex items-center gap-3 mb-stack-md">
                <div class="w-10 h-10 rounded-xl bg-primary-container/15 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">lock</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Update Password</h2>
                </div>
            </div>
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-error/20 p-stack-lg">
            <div class="flex items-center gap-3 mb-stack-md">
                <div class="w-10 h-10 rounded-xl bg-error-container/60 flex items-center justify-center">
                    <span class="material-symbols-outlined text-error">warning</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Danger Zone</h2>
                </div>
            </div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
