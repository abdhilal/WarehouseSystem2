@props([
    'action' => '',
    'text' => 'back',
])
<a href="{{ $action }}" class="btn btn-sm btn-outline-secondary">{{ __($text) }}</a>
