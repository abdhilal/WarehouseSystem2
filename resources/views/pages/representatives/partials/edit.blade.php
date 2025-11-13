@extends('layouts.app')
    @php
        $title = __('Edit Representative');
        $action = route('representatives.update', $representative);
        $method = 'PUT';
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
    {{ __('edit') }}
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
            <x-input name="name" label="{{__('name')}}" :model="$representative" required />

            <x-select name="warehouse_id" label="{{ __('Warehouse') }}" :options="$warehouseOptions" :model="$representative" placeholder="{{ __('Choose...') }}" col="6" />

            <x-select name="area_id" label="{{ __('Area') }}" :options="$areaOptions" :model="$representative" placeholder="{{ __('Choose...') }}" col="6" />

            <x-input name="email" type="email" label="{{__('email')}}" :model="$representative" required />

            <x-input name="password" type="password" label="{{__('password')}}" help="{{__('min 8 chars')}}" />
            <x-input name="password_confirmation" type="password" label="{{__('confirm password')}}" />

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <x-cancel route="representatives.index" />
            </div>
        </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection