@extends('layouts.app')
@section('title')
    {{ __('edit product') }}
@endsection
@section('subTitle')
    {{ __('edit product') }}
@endsection
@section('breadcrumb')
    {{ __('Products') }}
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
          <h5 class="mb-0">{{ __('Edit Product') }}</h5>
        </div>
        <div class="card-body">
          <x-form :action="route('products.update', $product)" method="PUT" class="row g-3" novalidate>
            <x-input name="name" label="{{ __('Name') }}" :model="$product" required col="6" />
            <x-input name="unit_price" type="number" label="{{ __('Unit Price') }}" :model="$product" step="0.01" col="6" />
            <x-select name="factory_id" label="{{ __('Factory') }}" :options="$factories->pluck('name','id')->toArray()" :model="$product" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="warehouse_id" label="{{ __('Warehouse') }}" :options="$warehouses->pluck('name','id')->toArray()" :model="$product" placeholder="{{ __('Choose...') }}" col="6" required />
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <x-cancel route="products.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection