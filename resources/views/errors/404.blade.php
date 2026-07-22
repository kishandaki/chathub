@extends('layouts.auth')

@section('title', 'Page Not Found - Chat HUB')

@section('content')
<x-auth.card title="Page Not Found" subtitle="The page you're looking for doesn't exist">
    <div class="auth-status">
        <div class="status-icon" style="background: var(--warning-soft); color: var(--warning);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <p>The page you are looking for doesn't exist or has been moved. Please check the URL or navigate back.</p>
    </div>

    <div class="auth-actions">
        <a href="{{ route('login') }}" class="btn btn-primary btn-full">Back to Login</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection