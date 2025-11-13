@extends('layouts.app')
@section('title')
    {{ __('Product details') }}
@endsection
@section('subTitle')
    {{ __('Product details') }}
@endsection
@section('breadcrumb')
    {{ __('Products') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Product details') }}</h5>
        <div>
          <x-edit :action="route('products.edit', $product)" />
          <x-back :action="route('products.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $product->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $product->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Unit Price') }}</th>
                <td>{{ $product->unit_price }}</td>
              </tr>
              <tr>
                <th>{{ __('Factory') }}</th>
                <td>{{ $product->factory?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $product->warehouse?->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection