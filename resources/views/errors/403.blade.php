@extends('layouts.auth')

@section('title', 'Access Denied - Chat HUB')

@section('content')
<x-auth.card title="Access Denied" subtitle="You don't have permission to access this resource">
    <div class="auth-status">
        <div class="status-icon" style="background: var(--danger-soft); color: var(--danger);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </div>
        <p>You don't have the required permissions to view this page. Please contact your administrator if you believe this is a mistake.</p>
    </div>

    <div class="auth-actions">
        <a href="{{ route('login') }}" class="btn btn-primary btn-full">Back to Login</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection