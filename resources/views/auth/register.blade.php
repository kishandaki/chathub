@extends('layouts.auth')

@section('title', 'Create Account - Chat HUB')

@section('content')
<x-auth.card title="Create your account" subtitle="Get started with Chat HUB for free">
    <form method="POST" action="{{ route('register') }}" autocomplete="off" class="auth-form">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div class="alert-content">Please fix the errors below and try again.</div>
            </div>
        @endif

        <div class="form-field">
            <label for="name">Full name</label>
            <input
                type="text"
                name="name"
                id="name"
                placeholder="John Doe"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
            />
            <x-auth.validation-error :message="$errors->first('name')" />
        </div>

        <div class="form-field">
            <label for="email">Email address</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="name@company.com"
                value="{{ old('email') }}"
                required
                autocomplete="email"
            />
            <x-auth.validation-error :message="$errors->first('email')" />
        </div>

        <div class="form-field">
            <label for="password">Password</label>
            <x-auth.password-input
                name="password"
                placeholder="Minimum 8 characters"
                required
                autocomplete="new-password"
            />
            <x-auth.validation-error :message="$errors->first('password')" />
        </div>

        <div class="form-field">
            <label for="password_confirmation">Confirm password</label>
            <x-auth.password-input
                name="password_confirmation"
                placeholder="Re-enter your password"
                required
                autocomplete="new-password"
            />
            <x-auth.validation-error :message="$errors->first('password_confirmation')" />
        </div>

        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Create Account</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">Sign in</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection