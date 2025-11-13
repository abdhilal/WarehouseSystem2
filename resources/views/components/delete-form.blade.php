    @props([
        'action' => '',
        'text' => 'delete',
    ])
   <form action="{{ $action }}" method="POST" style="display:inline-block">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-sm sweet-5" type="button"> {{ __($text) }}</button>
    </form>
