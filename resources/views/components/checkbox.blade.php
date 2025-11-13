@props([
    'name',
    'label' => null,
    'checked' => null,
    'model' => null,
    'id' => null,
    'valueChecked' => 1,
    'valueUnchecked' => 0,
    'col' => 12,
    'required' => false,
])

@php
    $id = $id ?? $name . '_checkbox';
    $currentChecked = old($name, $checked ?? ($model ? (bool) data_get($model, $name) : false));
@endphp

<div class="col-md-{{ $col }}">
    <div class="form-check mb-3">
        <input type="hidden" name="{{ $name }}" value="{{ $valueUnchecked }}">
        <input
            class="form-check-input"
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $valueChecked }}"
            @checked($currentChecked)
            @if($required) required @endif
            {{ $attributes }}
        >
        @if($label)
            <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
        @endif

        @error($name)
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
</div>