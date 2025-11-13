 @props([
    'action' => '',
    'text' => 'restore',
])
 <form method="POST" action="{{ $action }}" style="display:inline-block">
     @csrf
     @method('PUT')
     <button class="btn btn-sm btn-outline-success sweet-5">{{ __($text) }}</button>
 </form>
