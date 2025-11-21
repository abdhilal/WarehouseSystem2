@extends('layouts.app')
@section('title')
    {{ __('edit representative') }}
@endsection
@section('subTitle')
    {{ __('edit representative') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives') }}
@endsection
@section('breadcrumbActive')
    {{ __('edit') }}
@endsection
@section('content')
    @php
        $representativesMedical = $representative;
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Edit Representative') }}</h5>
                    </div>
                    <div class="card-body">
                        <x-form action="{{ route('representativesMedical.update', $representative->id) }}" method="PUT">
                            <x-input name="name" label="{{ __('Name') }}" :model="$representativesMedical" required col="6" />
                            <x-select name="area_id" label="{{ __('Area') }}" :options="$areas->pluck('name', 'id')->toArray()" :model="$representativesMedical"
                                placeholder="{{ __('Choose...') }}" col="6" required />
                            <x-select name="warehouse_id" label="{{ __('Warehouse') }}" :options="$warehouses->pluck('name', 'id')->toArray()" :model="$representativesMedical->warehouse_id"
                                placeholder="{{ __('Choose...') }}" col="6" required />
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
