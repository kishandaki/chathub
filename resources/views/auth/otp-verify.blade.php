@extends('layouts.auth')

@section('title', 'Verify OTP - Chat HUB')

@section('content')
<x-auth.card title="Verify your identity" subtitle="Enter the verification code sent to your email">
    <form method="POST" action="{{ route('otp.verify') }}" autocomplete="off" class="auth-form">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div class="alert-content">Invalid or expired code. Please try again.</div>
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-success">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <div class="alert-content">A new code has been sent to your email.</div>
            </div>
        @endif

        <div class="form-field">
            <label for="otp">One-Time Password</label>
            <input
                type="text"
                name="otp"
                id="otp"
                placeholder="000000"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                value="{{ old('otp') }}"
                required
                autofocus
                class="code-input"
            />
            <x-auth.validation-error :message="$errors->first('otp')" />
        </div>

        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Verify Code</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <button type="button" class="btn btn-link" onclick="document.getElementById('resend-otp-form').submit();">Resend code</button>
        <form id="resend-otp-form" method="POST" action="{{ route('otp.resend') }}" style="display: none;">@csrf</form>
        <a href="{{ route('login') }}">Back to sign in</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection