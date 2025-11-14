@extends('layouts.app')
@section('title')
    {{ __('Transactions') }}
@endsection
@section('subTitle')
    {{ __('edit') }}
@endsection
@section('breadcrumb')
    {{ __('Transactions') }}
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
          <h5 class="mb-0">{{ __('Edit Transaction') }}</h5>
        </div>
        <div class="card-body">
          <x-form :action="route('transactions.update', $transaction)" method="PUT" class="row g-3" novalidate>
            <x-select name="warehouse_id" label="{{ __('Warehouse') }}" :options="$warehouses->pluck('name','id')->toArray()" :model="$transaction" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="factory_id" label="{{ __('Factory') }}" :options="$factories->pluck('name','id')->toArray()" :model="$transaction" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="pharmacy_id" label="{{ __('Pharmacy') }}" :options="$pharmacies->pluck('name','id')->toArray()" :model="$transaction" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="representative_id" label="{{ __('Representative') }}" :options="$representatives->pluck('name','id')->toArray()" :value="optional($transaction->representative)->id" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="product_id" label="{{ __('Product') }}" :options="$products->pluck('name','id')->toArray()" :model="$transaction" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="type" label="{{ __('Type') }}" :options="collect($types)->flatMap(fn($t) => [ $t => __($t) ])->toArray()" :value="$transaction->type" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-input name="quantity" type="number" label="{{ __('Quantity') }}" :value="$transaction->quantity_product" min="0" step="1" col="6" required />
            <x-input name="value" type="number" label="{{ __('Value') }}" :value="$transaction->value_income" min="0" step="0.01" col="6" />
            <x-input name="gift_value" type="number" label="{{ __('Gift Value') }}" :value="$transaction->value_gift" min="0" step="0.01" col="6" />
            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
              <x-cancel route="transactions.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection