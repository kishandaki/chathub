@extends('layouts.auth')

@section('title', 'Two-Factor Authentication - Chat HUB')

@section('content')
<x-auth.card title="Two-Factor Authentication" subtitle="Enter the 6-digit code sent to your device">
    <form method="POST" action="{{ route('two-factor') }}" autocomplete="off">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <div class="alert-content">
                    Invalid or expired code. Please try again.
                </div>
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-success">
                <div class="alert-content">
                    A new code has been sent.
                </div>
            </div>
        @endif

        <div class="form-field">
            <label for="code">Verification Code</label>
            <input
                type="text"
                name="code"
                id="code"
                placeholder="000000"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                value="{{ old('code') }}"
                required
                autofocus
                style="text-align: center; font-size: 24px; font-weight: 800; letter-spacing: 8px;"
            />
            <x-auth.validation-error :message="$errors->first('code')" />
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
            Verify
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--soft-text);">
        <button type="button" class="btn btn-secondary" style="background: transparent; border: 0; color: var(--primary); font-weight: 700; padding: 0;" onclick="document.getElementById('resend-form').submit();">
            Resend Code
        </button>
        <form id="resend-form" method="POST" action="{{ route('two-factor.resend') }}" style="display: none;">
            @csrf
        </form>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection