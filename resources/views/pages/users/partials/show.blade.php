@extends('layouts.app')
@section('title')
    {{ __('user details') }}
@endsection
@section('subTitle')
    {{ __('user details') }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{__('show')}}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{__('user details')}}</h5>
        <div>
          @isset($user)
          <x-edit :action="route('users.edit', $user)" />
          @endisset
          <x-back :action="route('users.index')" />
        </div>
      </div>
      <div class="card-body">
        @isset($user)
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th style="width: 200px">#</th>
                <td>{{ $user->id }}</td>
              </tr>
              <tr>
                <th>{{__('name')}}</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>{{__('email')}}</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>{{__('email verified')}}</th>
                <td>{{ $user->email_verified_at ? __('yes') : __('no') }}</td>
              </tr>
              <tr>
                <th>{{__('status')}}</th>
                <td>{{ $user->is_active ? __('active') : __('inactive') }}</td>
              </tr>
              <tr>
                <th>{{__('created at')}}</th>
                <td>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('Y-m-d H:i') }}</td>
              </tr>
              <tr>
                <th>{{__('updated at')}}</th>
                <td>{{ \Illuminate\Support\Carbon::parse($user->updated_at)->format('Y-m-d H:i') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        @else
          <p class="text-muted">{{__('no user data to display')}}</p>
        @endisset
      </div>
    </div>
  </div>
</div>
@endsection