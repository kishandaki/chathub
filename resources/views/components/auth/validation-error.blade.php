@props(['message'])

@if($message)
    <span class="validation-error" role="alert">
        {{ $message }}
    </span>
@endif