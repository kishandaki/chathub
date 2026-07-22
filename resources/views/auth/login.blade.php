@extends('layouts.auth')

@section('title', 'Login - Chat HUB')

@section('content')
<x-auth.card title="Welcome back" subtitle="Sign in to your account to continue">
    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="auth-form">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div class="alert-content">Invalid email or password. Please try again.</div>
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

        <div class="form-field">
            <label for="password">Password</label>
            <x-auth.password-input
                name="password"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            />
            <x-auth.validation-error :message="$errors->first('password')" />
        </div>

        <div class="form-field">
            <div class="checkbox-wrapper">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    {{ old('remember') ? 'checked' : '' }}
                />
                <label for="remember">Remember me for 30 days</label>
            </div>
        </div>

        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Sign In</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('forgot.password') }}">Forgot your password?</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection
