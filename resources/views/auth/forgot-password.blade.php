@extends('layouts.auth')

@section('title', 'Forgot Password - Chat HUB')

@section('content')
<x-auth.card title="Reset your password" subtitle="Enter your email and we'll send you a reset link">
    <form method="POST" action="{{ route('forgot.password') }}" autocomplete="off">
        @csrf

        @if(session('status'))
            <div class="alert alert-success">
                <div class="alert-content">
                    We've sent you a password reset link. Please check your inbox.
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

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
            Send Reset Link
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px; font-size: 13px; color: var(--soft-text);">
        <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">
            Back to sign in
        </a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection