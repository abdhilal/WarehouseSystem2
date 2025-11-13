@props([
    'href' => null,
    'route' => null,
    'label' => null,
    'col' => 12,
    'class' => 'btn btn-secondary',
])

@php
    $url = $href ?? ($route ? route($route) : '#');
    $label = $label ?? __('cancel');
@endphp

<div class="col-md-{{ $col }}">
    <a href="{{ $url }}" class="{{ $class }}" {{ $attributes }}>{{ $label }}</a>
</div>