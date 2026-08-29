@extends('layouts.site')

@section('title', 'LinkAudit Pro | Professional Insight System')

@section('content')
    <x-navbar />

    <main class="relative z-10 pt-[120px] pb-32">
        <x-hero />
        <x-how-it-works />
    </main>

    <x-footer />
@endsection
