@extends('layouts.auth')

@section('title', 'Forgot Password - Chat HUB')

@section('content')
<x-auth.card title="Forgot your password?" subtitle="Enter your email and we'll send you a reset link">
        <form method="POST" action="{{ route('password.request') }}" autocomplete="off" class="auth-form">
        @csrf

        @if(session('status'))
            <div class="alert alert-success">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <div class="alert-content">We've sent you a password reset link. Please check your inbox.</div>
            </div>
        @endif

        <div class="form-field">
            <label for="email">Email address</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="name@company.com"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
            />
            <x-auth.validation-error :message="$errors->first('email')" />
        </div>

        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Send Reset Link</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Back to sign in</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection
