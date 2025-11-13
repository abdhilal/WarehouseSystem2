@extends('layouts.app')
@section('title')
    {{ __('Representative details') }}
@endsection
@section('subTitle')
    {{ __('Representative details') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Representative details') }}</h5>
        <div>
          <x-edit :action="route('representatives.edit', $representative)" />
          <x-back :action="route('representatives.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $representative->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $representative->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Email') }}</th>
                <td>{{ $representative->email }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $representative->warehouse?->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Area') }}</th>
                <td>{{ $representative->area?->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection