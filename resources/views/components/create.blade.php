@props([
    'action' => '',
    'text' => 'create',
])
<a href="{{ $action }}" class="btn btn-sm btn-outline-success">{{ __($text) }}</a>
