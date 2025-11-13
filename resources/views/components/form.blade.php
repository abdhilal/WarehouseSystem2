@props([
    'action',
    'method' => 'POST',
    'enctype' => null,
    'novalidate' => false,
])

@php
    $methodUpper = strtoupper($method);
    $isGet = $methodUpper === 'GET';
    $spoofNeeded = !in_array($methodUpper, ['GET', 'POST']);
@endphp

<form method="{{ $isGet ? 'GET' : 'POST' }}" action="{{ $action }}" @if($enctype) enctype="{{ $enctype }}" @endif @if($novalidate) novalidate @endif {{ $attributes }}>
    @csrf
    @if($spoofNeeded)
        @method($methodUpper)
    @endif

    {{ $slot }}
</form>