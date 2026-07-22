@extends('layouts.auth')

@section('title', 'Account Locked - Chat HUB')

@section('content')
<x-auth.card title="Account Locked" subtitle="Your account has been temporarily locked due to multiple failed login attempts">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="width: 64px; height: 64px; border-radius: 23px; background: var(--danger-soft); color: var(--danger); display: grid; place-items: center; margin: 0 auto 16px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
            </svg>
        </div>
        <p style="color: var(--soft-text); font-size: 14px; line-height: 1.6;">
            Your account is locked for security purposes. Please try again later or contact support if you need assistance.
        </p>
    </div>

    <div class="alert alert-warning">
        <div class="alert-content">
            Try again in <strong id="countdown">15:00</strong>
        </div>
    </div>

    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center;">
        Back to Login
    </a>
</x-auth.card>

<script>
(function() {
    const countdownEl = document.getElementById('countdown');
    if (!countdownEl) return;
    
    const lockedUntil = new Date('{{ $lockedUntil ?? now()->addMinutes(15) }}');
    const interval = setInterval(() => {
        const now = new Date();
        const diff = lockedUntil - now;
        if (diff <= 0) {
            clearInterval(interval);
            countdownEl.textContent = '00:00';
            return;
        }
        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);
        countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
    }, 1000);
})();
</script>

<x-auth.loader />
<x-auth.toast />
@endsection