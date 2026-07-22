@props([
    'type' => 'submit',
    'variant' => 'primary',
    'disabled' => false,
])

<button
    type="{{ $type }}"
    class="btn btn-{{ $variant }}"
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>