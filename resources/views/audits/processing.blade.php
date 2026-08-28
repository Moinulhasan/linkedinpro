@extends('layouts.site')

@section('title', 'LinkAudit Pro - Diagnosis in Progress')

@section('content')
    <main class="flex-grow flex items-center justify-center p-margin-mobile md:p-margin-desktop relative overflow-hidden min-h-screen bg-on-surface text-surface-bright">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none flex justify-center items-center">
            <div class="w-[800px] h-[800px] bg-primary/10 rounded-full blur-[120px] absolute opacity-50"></div>
            <div class="w-[400px] h-[400px] bg-primary-fixed-dim/10 rounded-full blur-[80px] absolute translate-x-1/2 translate-y-1/2"></div>
        </div>
        <x-processing-panel />
    </main>

    <script>
        window.auditStatusUrl = @json(route('profile-audits.status', $audit));
    </script>
@endsection
