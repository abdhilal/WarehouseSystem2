@props(
    [
        'model' => null,
        'action' => '',
    ]
)
<div class="form-check form-switch">
    <form action="{{ route($action, $model) }}" method="post">
        @csrf
        @method('put')
        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" role="switch"
            {{ $model->is_active ? 'checked' : '' }} 
            onclick="this.form.submit()">
        <label class="form-check-label"
            for="flexSwitchCheckDefault">{{ $model->is_active ? __('active') : __('inactive') }}</label>
    </form>
</div>
