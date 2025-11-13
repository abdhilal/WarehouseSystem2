@extends('layouts.app')
@section('title')
    {{ __('edit warehouse') }}
@endsection
@section('subTitle')
    {{ __('edit warehouse') }}
@endsection
@section('breadcrumb')
    {{ __('Warehouses') }}
@endsection
@section('breadcrumbActive')
    {{ __('edit') }}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content بين align-items-center">
          <h5 class="mb-0">{{ __('Edit Warehouse') }}</h5>
        </div>
        <div class="card-body">
          <x-form :action="route('warehouses.update', $warehouse)" method="PUT" class="row g-3" novalidate>
            <x-input name="name" label="{{ __('Name') }}" :model="$warehouse" required col="6" />
            <x-input name="location" label="{{ __('Location') }}" :model="$warehouse" col="6" />
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <x-cancel route="warehouses.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection