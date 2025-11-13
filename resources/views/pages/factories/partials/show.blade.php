@extends('layouts.app')
@section('title')
    {{ __('Factory details') }}
@endsection
@section('subTitle')
    {{ __('Factory details') }}
@endsection
@section('breadcrumb')
    {{ __('Factories') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Factory details') }}</h5>
        <div>
          <x-edit :action="route('factories.edit', $factory)" />
          <x-back :action="route('factories.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $factory->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $factory->name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection