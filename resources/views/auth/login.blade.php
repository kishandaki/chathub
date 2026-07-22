@extends('layouts.auth')

@section('title', 'Login - Chat HUB')

@section('content')
<x-auth.card title="Sign in to Chat HUB" subtitle="Enter your credentials to access your account">
    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <div class="alert-content">
                    Invalid email or password. Please try again.
                </div>
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

        <div class="form-field" style="flex-direction: row; align-items: center; gap: 10px; margin-top: 4px;">
            <input
                type="checkbox"
                name="remember"
                id="remember"
                style="width: 18px; height: 18px; accent-color: var(--primary);"
                {{ old('remember') ? 'checked' : '' }}
            />
            <label for="remember" style="margin: 0; font-weight: 600; font-size: 13px; cursor: pointer;">
                Remember me for 30 days
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
            Sign In
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--soft-text);">
        <a href="{{ route('forgot.password') }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">
            Forgot your password?
        </a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection