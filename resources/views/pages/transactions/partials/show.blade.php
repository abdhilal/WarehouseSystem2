@extends('layouts.app')
@section('title')
    {{ __('Transactions') }}
@endsection
@section('subTitle')
    {{ __('show') }}
@endsection
@section('breadcrumb')
    {{ __('Transactions') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Transaction details') }}</h5>
        <div>
          <x-edit :action="route('transactions.edit', $transaction)" />
          <x-back :action="route('transactions.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $transaction->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Type') }}</th>
                <td>{{ __($transaction->type) }}</td>
              </tr>
              <tr>
                <th>{{ __('Product') }}</th>
                <td>{{ $transaction->product?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Pharmacy') }}</th>
                <td>{{ $transaction->pharmacy?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Representative') }}</th>
                <td>{{ $transaction->representative?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Quantity Product') }}</th>
                <td>{{ $transaction->quantity_product }}</td>
              </tr>
              <tr>
                <th>{{ __('Value Income') }}</th>
                <td>{{ $transaction->value_income }}</td>
              </tr>
              <tr>
                <th>{{ __('Value Output') }}</th>
                <td>{{ $transaction->value_output }}</td>
              </tr>
              <tr>

                <th>{{ __('Quantity Gift') }}</th>
                <td>{{ $transaction->quantity_gift }}</td>
              </tr>
              <tr>

                <th>{{ __('Gift Value') }}</th>
                <td>{{ $transaction->value_gift }}</td>
              </tr>
              <tr>
                <th>{{ __('Factory') }}</th>
                <td>{{ $transaction->factory?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $transaction->warehouse?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Area') }}</th>
                <td>{{ $transaction->area?->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
