@extends('layouts.app')
@section('title')
    {{ __('User details') }}
@endsection
@section('subTitle')
    {{ __('User details') }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('User details') }}</h5>
        <div>
          <x-edit :action="route('users.edit', $user)" />
          <x-back :action="route('users.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>#</th>
                <td>{{ $user->id }}</td>
              </tr>
              <tr>
                <th>{{ __('Name') }}</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>{{ __('Email') }}</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>{{ __('Warehouse') }}</th>
                <td>{{ $user->warehouse?->name }}</td>
              </tr>
              <tr>
              
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
