@extends('layouts.auth')

@section('title', 'Verify Email - Chat HUB')

@section('content')
<x-auth.card title="Verify your email" subtitle="We've sent a verification link to your inbox">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="width: 64px; height: 64px; border-radius: 23px; background: var(--primary-soft); color: var(--primary); display: grid; place-items: center; margin: 0 auto 16px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
        </div>
        <p style="color: var(--soft-text); font-size: 14px; line-height: 1.6;">
            Please check your email and click the verification link to activate your account.
            If you don't see it, check your spam folder.
        </p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            <div class="alert-content">
                A new verification link has been sent.
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}" style="text-align: center;">
        @csrf
        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Resend Verification Email
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--soft-text);">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--primary); text-decoration: none; font-weight: 700;">
            Sign out
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection