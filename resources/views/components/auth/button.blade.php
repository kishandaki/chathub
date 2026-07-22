@props([
    'type' => 'submit',
    'variant' => 'primary',
    'disabled' => false,
    'full' => false,
    'icon' => null,
])

<button
    type="{{ $type }}"
    class="btn btn-{{ $variant }}{{ $full ? ' btn-full' : '' }}"
    @if($disabled) disabled @endif
>
    @if($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</button>
