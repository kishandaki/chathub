@extends('layouts.auth')

@section('title', 'Unauthorized - Chat HUB')

@section('content')
<div style="text-align: center;">
    <div style="width: 64px; height: 64px; border-radius: 23px; background: var(--danger-soft); color: var(--danger); display: grid; place-items: center; margin: 0 auto 16px;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </div>
    <h1 style="font-size: 48px; font-weight: 900; margin: 0 0 8px; color: var(--text);">403</h1>
    <p style="font-size: 18px; color: var(--muted); margin: 0 0 24px;">Unauthorized Access</p>
    <p style="color: var(--soft-text); font-size: 14px; max-width: 400px; margin: 0 auto 32px; line-height: 1.6;">
        Sorry, you don't have permission to access this page. Please contact your administrator if you believe this is an error.
    </p>
    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; max-width: 300px; display: inline-flex; justify-content: center;">
        Back to Dashboard
    </a>
</div>
@endsection