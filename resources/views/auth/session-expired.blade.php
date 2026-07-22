@extends('layouts.auth')

@section('title', 'Session Expired - Chat HUB')

@section('content')
<x-auth.card title="Session Expired" subtitle="Your session has timed out for security reasons">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="width: 64px; height: 64px; border-radius: 23px; background: var(--warning-soft); color: var(--warning); display: grid; place-items: center; margin: 0 auto 16px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <p style="color: var(--soft-text); font-size: 14px; line-height: 1.6;">
            For your security, we've ended your session due to inactivity. Please sign in again to continue.
        </p>
    </div>

    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">
        Sign In Again
    </a>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection