@props([
    'name',
    'label' => null,
    'value' => null,
    'model' => null,
    'id' => null,
    'help' => null,
    'rows' => 3,
    'col' => 12,
    'required' => false,
])

@php
    $id = $id ?? $name . '_textarea';
    $current = old($name, $value ?? ($model ? data_get($model, $name) : null));
@endphp

<div class="col-md-{{ $col }}">
    <div class="mb-3">
        @if($label)
            <label class="form-label" for="{{ $id }}">{{ $label }}</label>
        @endif

        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            rows="{{ $rows }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'form-control']) }}
        >{{ $current }}</textarea>

        @error($name)
            <div class="text-danger small">{{ $message }}</div>
        @enderror

        @if($help)
            <div class="form-text">{{ $help }}</div>
        @endif
    </div>
</div>