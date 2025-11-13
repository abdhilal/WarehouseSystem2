@extends('layouts.app')
    @php
        $isEdit = isset($user) && $user->exists;
        $title = $isEdit ? __('edit user') : __('add new user');
        $action = $isEdit ? route('users.update', $user) : route('users.store');
        $method = $isEdit ? 'PUT' : 'POST';
    @endphp
@section('title')
    {{ $title }}
@endsection
@section('subTitle')
    {{ $title }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{ $isEdit ? __('edit') : __('add new') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
        <x-form :action="$action" :method="$method" class="row g-3" novalidate>
            <x-input name="name" label="{{__('name')}}" :model="$user" required />

            <x-input name="email" type="email" label="{{__('email')}}" :model="$user" required />

            @if(!$isEdit)
                <x-input name="password" type="password" label="{{__('password')}}" required help="{{__('min 8 chars')}}" />
                <x-input name="password_confirmation" type="password" label="{{__('confirm password')}}" required />
            @endif

            <x-switch-checkbox name="is_active" label="{{__('status')}}" :model="$user" />

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{__('save')}}</button>
                <x-cancel route="users.index" />
            </div>
        </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection