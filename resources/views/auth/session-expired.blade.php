@extends('layouts.auth')

@section('title', 'Session Expired - Chat HUB')

@section('content')
<x-auth.card title="Session Expired" subtitle="Your session has timed out for security reasons">
    <div class="auth-status">
        <div class="status-icon" style="background: var(--warning-soft); color: var(--warning);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <p>For your security, we've ended your session due to inactivity. Please sign in again to continue.</p>
    </div>

    <div class="auth-actions">
        <a href="{{ route('login') }}" class="btn btn-primary btn-full">Sign In Again</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection
