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
</body>
</html>
