@extends('layouts.auth')

@section('title', 'Change Password - Chat HUB')

@section('content')
<x-auth.card title="Change your password" subtitle="Choose a new strong password for your account">
    <form method="POST" action="{{ route('change.password') }}" autocomplete="off" class="auth-form">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div class="alert-content">Please fix the errors below and try again.</div>
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-success">
                <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <div class="alert-content">Your password has been changed successfully.</div>
            </div>
        @endif

        <div class="form-field">
            <label for="current_password">Current password</label>
            <x-auth.password-input
                name="current_password"
                placeholder="Enter your current password"
                required
                autofocus
                autocomplete="current-password"
            />
            <x-auth.validation-error :message="$errors->first('current_password')" />
        </div>

        <div class="form-field">
            <label for="new_password">New password</label>
            <x-auth.password-input
                name="new_password"
                placeholder="Minimum 8 characters"
                required
                autocomplete="new-password"
            />
            <x-auth.validation-error :message="$errors->first('new_password')" />
        </div>

        <div class="form-field">
            <label for="new_password_confirmation">Confirm new password</label>
            <x-auth.password-input
                name="new_password_confirmation"
                placeholder="Re-enter your new password"
                required
                autocomplete="new-password"
            />
            <x-auth.validation-error :message="$errors->first('new_password_confirmation')" />
        </div>

        <div class="auth-actions">
            <x-auth.button type="submit" variant="primary" full>Update Password</x-auth.button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Back to sign in</a>
    </div>
</x-auth.card>

<x-auth.loader />
<x-auth.toast />
@endsection