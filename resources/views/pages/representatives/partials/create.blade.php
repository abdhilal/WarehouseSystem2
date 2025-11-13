@extends('layouts.app')
    @php
        $isEdit = isset($representative) && $representative->exists;
        $title = $isEdit ? __('edit representative') : __('add new representative');
        $action = $isEdit ? route('representatives.update', $representative) : route('representatives.store');
        $method = $isEdit ? 'PUT' : 'POST';
        $warehouseOptions = ($warehouses ?? collect())->pluck('name', 'id')->toArray();
        $areaOptions = ($areas ?? collect())->pluck('name', 'id')->toArray();
    @endphp
@section('title')
    {{ $title }}
@endsection
@section('subTitle')
    {{ $title }}
@endsection
@section('breadcrumb')
    {{ __('Representatives') }}
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
            <x-input name="name" label="{{__('name')}}" :model="$representative ?? null" required />

            <x-select name="warehouse_id" label="{{ __('Warehouse') }}" :options="$warehouseOptions" :model="$representative ?? null" placeholder="{{ __('Choose...') }}" col="6" />

            <x-select name="area_id" label="{{ __('Area') }}" :options="$areaOptions" :model="$representative ?? null" placeholder="{{ __('Choose...') }}" col="6" />

            <x-input name="email" type="email" label="{{__('email')}}" :model="$representative ?? null" required />

            @if(!$isEdit)
                <x-input name="password" type="password" label="{{__('password')}}" required help="{{__('min 8 chars')}}" />
                <x-input name="password_confirmation" type="password" label="{{__('confirm password')}}" required />
            @endif

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{__('save')}}</button>
                <x-cancel route="representatives.index" />
            </div>
        </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
