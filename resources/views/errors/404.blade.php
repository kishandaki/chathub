@extends('layouts.auth')

@section('title', 'Page Not Found - Chat HUB')

@section('content')
<div style="text-align: center;">
    <div style="width: 64px; height: 64px; border-radius: 23px; background: var(--warning-soft); color: var(--warning); display: grid; place-items: center; margin: 0 auto 16px;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
    </div>
    <h1 style="font-size: 48px; font-weight: 900; margin: 0 0 8px; color: var(--text);">404</h1>
    <p style="font-size: 18px; color: var(--muted); margin: 0 0 24px;">Page Not Found</p>
    <p style="color: var(--soft-text); font-size: 14px; max-width: 400px; margin: 0 auto 32px; line-height: 1.6;">
        The page you are looking for doesn't exist or has been moved. Please check the URL or navigate back to the dashboard.
    </p>
    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; max-width: 300px; display: inline-flex; justify-content: center;">
        Back to Dashboard
    </a>
</div>
@endsection