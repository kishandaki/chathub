@props([
    'type' => 'info',
    'dismissible' => false,
])

@php
    $styles = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];
@endphp

<div class="alert {{ $styles[$type] ?? 'alert-info' }}" role="alert">
    <div class="alert-content">
        {{ $slot ?? '' }}
    </div>
    @if($dismissible)
        <button type="button" class="alert-close" aria-label="Close alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    @endif
</div>