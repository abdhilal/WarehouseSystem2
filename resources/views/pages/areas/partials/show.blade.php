@extends('layouts.app')
@section('title')
    {{ __('Area details') }}
@endsection
@section('subTitle')
    {{ __('Area details') }}
@endsection
@section('breadcrumb')
    {{ __('Areas') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Area details') }}</h5>
        <div>
          <x-edit :action="route('areas.edit', $area)" />
          <x-back :action="route('areas.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $area->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $area->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $area->warehouse?->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection