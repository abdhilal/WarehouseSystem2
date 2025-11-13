@extends('layouts.app')
@section('title')
    {{ __('Products list') }}
@endsection
@section('subTitle')
    {{ __('Products list') }}
@endsection
@section('breadcrumb')
    {{ __('Products') }}
@endsection
@section('breadcrumbActive')
    {{ __('Products') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Products list') }}</h5>
          @can('create-product')
            <x-create :action="route('products.create')" />
          @endcan
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Factory') }}</th>
                <th>{{ __('Warehouse') }}</th>
                <th>{{ __('Unit Price') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $index => $product)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->factory?->name }}</td>
                  <td>{{ $product->warehouse?->name }}</td>
                  <td>{{ $product->unit_price }}</td>
                  <td>
                    @can('show-product')
                      <x-show :action="route('products.show', $product)" />
                    @endcan
                    @can('edit-product')
                      <x-edit :action="route('products.edit', $product)" />
                    @endcan
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">{{ __('No products found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if ($products->count())
        <div class="card-footer">
          @include('layouts.partials.pagination', ['page' => $products])
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
