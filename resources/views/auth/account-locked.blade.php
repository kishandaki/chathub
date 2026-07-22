@extends('layouts.auth')

@section('title', 'Account Locked - Chat HUB')

@section('content')
<x-auth.card title="Account Locked" subtitle="Your account has been temporarily locked">
    <div class="auth-status">
        <div class="status-icon" style="background: var(--danger-soft); color: var(--danger);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
            </svg>
        </div>
        <p>Your account is locked for security purposes. Please try again later or contact support if you need assistance.</p>
    </div>

    <div class="alert alert-warning" style="margin-top: 20px;">
        <svg class="alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div class="alert-content">
            Try again in <span class="countdown-display" id="countdown">15:00</span>
        </div>
    </div>

    <div class="auth-actions">
        <a href="{{ route('login') }}" class="btn btn-primary btn-full">Back to Login</a>
    </div>
</x-auth.card>

@push('scripts')
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
@endpush

<x-auth.loader />
<x-auth.toast />
@endsection
