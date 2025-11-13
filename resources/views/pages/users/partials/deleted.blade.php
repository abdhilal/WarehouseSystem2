@extends('layouts.app')
@section('title')
    {{__('Users.deleted')}}
@endsection
@section('subTitle')
    {{ __('Users.deleted') }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{ __('Deleted') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Users.deleted') }}</h5>
          <x-back :action="route('users.index')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('name') }}</th>
                <th>{{ __('email') }}</th>
                <th>{{ __('roles') }}</th>
                <th>{{ __('deleted_at') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                  <td>{{ optional($user->deleted_at)->format('Y-m-d H:i') }}</td>
                  <td>
                    <x-restore-form :action="route('users.restore', $user)" />
                    <x-delete-form :action="route('users.forceDelete', $user)" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">{{ __('No deleted users found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->count())
          <div class="card-footer">
              @include('layouts.partials.pagination', ['page' => $users])
          </div>
      @endif
    </div>
  </div>
</div>
@endsection