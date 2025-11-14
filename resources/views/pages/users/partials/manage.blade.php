@extends('layouts.app')
@section('title')
    {{ __('Users Permissions') }}
@endsection
@section('subTitle')
    {{ __('Users Permissions') }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{ __('permissions') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Users Permissions') }}</h5>
                </div>
                <div class="card-body">
                    <x-form :action="route('users.permissions.manage')" method="GET" class="row g-3 mb-4">
                        <x-select name="user" label="{{ __('Select User') }}" :options="$users->pluck('name', 'id')->toArray()" :value="optional($selectedUser)->id" placeholder="{{ __('Choose...') }}" col="6" id="user" onchange="this.form.submit()" />
                    </x-form>

                    @if($selectedUser)
                        <x-form :action="route('users.permissions.update', $selectedUser)" method="POST" class="row g-3">
                            <div class="col-12 d-flex align-items-center justify-content-between">
                                <strong>{{ __('Permissions') }}</strong>
                                <span class="text-title-gray">{{ __('Direct') }}: {{ count($direct) }} · {{ __('Via Role') }}: {{ count($viaRoles) }}</span>
                            </div>

                            @foreach($permissions->groupBy('group_name') as $group => $perms)
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <strong>{{ __($group) }}</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($perms as $perm)
                                                    @php $parts = explode('-', $perm->name, 2); $act = $parts[0] ?? $perm->name; $res = $parts[1] ?? ''; @endphp
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="perm_{{ $perm->id }}" name="permissions[]" value="{{ $perm->name }}" @checked(in_array($perm->name, $direct))>
                                                            <label class="form-check-label" for="perm_{{ $perm->id }}">{{ __($act) }} @if($res) - {{ __($res) }} @endif
                                                                @if(in_array($perm->name, $viaRoles) && !in_array($perm->name, $direct))
                                                                    <span class="badge bg-info ms-2">{{ __('Granted via role') }}</span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </x-form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection