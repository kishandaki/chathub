@extends('layouts.auth')

@section('title', 'Verify Email - Chat HUB')

@section('content')
<x-auth.card title="Verify your email" subtitle="We've sent a verification link to your inbox">
    <div class="auth-status">
        <div class="status-icon" style="background: var(--primary-soft); color: var(--primary);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
        </div>
        <p>Please check your email and click the verification link to activate your account. If you don't see it, check your spam folder.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <div class="alert-content">A new verification link has been sent.</div>
        </div>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}" class="auth-form">
        @csrf
        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Resend Verification Email</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection
