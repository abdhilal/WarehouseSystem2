@extends('layouts.app')
@section('title')
    {{ __('Warehouse details') }}
@endsection
@section('subTitle')
    {{ __('Warehouse details') }}
@endsection
@section('breadcrumb')
    {{ __('Warehouses') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Warehouse details') }}</h5>
        <div>
          <x-edit :action="route('warehouses.edit', $warehouse)" />
          <x-back :action="route('warehouses.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive mb-4">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $warehouse->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $warehouse->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Location') }}</th>
                <td>{{ $warehouse->location }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $representatives->count() }}</div>
                  <div class="text-title-gray">{{ __('Representatives') }}</div>
                </div>
                <i class="fa-solid fa-users text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->pharmacies->count() }}</div>
                  <div class="text-title-gray">{{ __('Pharmacies') }}</div>
                </div>
                <i class="fa-solid fa-house text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->areas->count() }}</div>
                  <div class="text-title-gray">{{ __('Areas') }}</div>
                </div>
                <i class="fa-solid fa-map-location-dot text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->products->count() }}</div>
                  <div class="text-title-gray">{{ __('Products') }}</div>
                </div>
                <i class="fa-solid fa-box text-muted"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->transactions->count() }}</div>
                  <div class="text-title-gray">{{ __('Transactions') }}</div>
                </div>
                <i class="fa-solid fa-arrows-rotate text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->transactions->where('type','Wholesale Sale')->count() }}</div>
                  <div class="text-title-gray">{{ __('Wholesale Sales') }}</div>
                </div>
                <i class="fa-solid fa-dollar-sign text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->transactions->where('type','Wholesale Return')->count() }}</div>
                  <div class="text-title-gray">{{ __('Wholesale Returns') }}</div>
                </div>
                <i class="fa-solid fa-rotate-left text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h3 mb-0">{{ $warehouse->transactions->where('type','Gift')->count() }}</div>
                  <div class="text-title-gray">{{ __('Gifts') }}</div>
                </div>
                <i class="fa-solid fa-star text-muted"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h2 mb-0">{{ $warehouse->transactions->sum('quantity') }}</div>
                  <div class="text-title-gray">{{ __('Total Quantity Moved') }}</div>
                </div>
                <i class="fa-solid fa-box text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h2 mb-0">{{ $warehouse->transactions->sum('value') }}</div>
                  <div class="text-title-gray">{{ __('Total Sales Value') }}</div>
                </div>
                <i class="fa-solid fa-dollar-sign text-muted"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <div class="h2 mb-0">{{ $warehouse->transactions->sum('gift_value') }}</div>
                  <div class="text-title-gray">{{ __('Total Gifts Value') }}</div>
                </div>
                <i class="fa-solid fa-gift text-muted"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection