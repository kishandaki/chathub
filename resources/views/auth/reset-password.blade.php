@extends('layouts.auth')

@section('title', 'Reset Password - Chat HUB')

@section('content')
<x-auth.card title="Set a new password" subtitle="Create a strong password for your account">
    <form method="POST" action="{{ route('reset.password') }}" autocomplete="off">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />
        <input type="hidden" name="email" value="{{ $email }}" />

        @if($errors->any())
            <div class="alert alert-danger">
                <div class="alert-content">
                    Please fix the errors below and try again.
                </div>
            </div>
        @endif

        <div class="form-field">
            <label for="email">Email address</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email', $email) }}"
                readonly
                disabled
            />
        </div>

        <div class="form-field">
            <label for="password">New password</label>
            <x-auth.password-input
                name="password"
                placeholder="Minimum 8 characters"
                required
                autofocus
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

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
            Reset Password
        </button>
    </form>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection