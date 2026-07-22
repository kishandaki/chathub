@props([
    'name',
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'autocomplete' => '',
    'value' => '',
])

<div class="form-field">
    @if($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    />
</div>