@extends('layouts.app')
@section('title')
    {{ __('add new factory') }}
@endsection
@section('subTitle')
    {{ __('add new factory') }}
@endsection
@section('breadcrumb')
    {{ __('Factories') }}
@endsection
@section('breadcrumbActive')
    {{ __('add new') }}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ __('Create Factory') }}</h5>
        </div>
        <div class="card-body">
          <x-form :action="route('factories.store')" method="POST" class="row g-3" novalidate>
            <x-input name="name" label="{{ __('Name') }}" required col="6" />
            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
              <x-cancel route="factories.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection