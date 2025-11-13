@extends('layouts.app')
@section('title')
    {{ __('Users.list') }}
@endsection
@section('subTitle')
    {{ __('Users.list') }}
@endsection
@section('breadcrumb')
    {{ __('Users') }}
@endsection
@section('breadcrumbActive')
    {{ __('Users') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Users.list') }}</h5>
                        <x-create :action="route('users.create')" />
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
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                          <x-toggle-active :model="$user" action="users.toggleActive" />
                                        </td>
                                        <td>
                                            <x-show :action="route('users.show', $user)" />
                                            <x-edit :action="route('users.edit', $user)" />
                                            <x-delete-form :action="route('users.destroy', $user)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No users found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $users])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
