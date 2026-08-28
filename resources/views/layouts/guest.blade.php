<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LinkAudit Pro') }}</title>

        @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-on-surface antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-background">
            <a href="{{ route('welcome') }}" class="font-display-lg text-headline-md tracking-tighter text-on-surface flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">analytics</span>
                LinkAudit Pro
            </a>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 glass-panel ambient-shadow overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
