@extends('layouts.app')
@section('title')
    {{ __('Warehouses list') }}
@endsection
@section('subTitle')
    {{ __('Warehouses list') }}
@endsection
@section('breadcrumb')
    {{ __('Warehouses') }}
@endsection
@section('breadcrumbActive')
    {{ __('Warehouses') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Warehouses list') }}</h5>
          <x-create :action="route('warehouses.create')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Location') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($warehouses as $index => $warehouse)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $warehouse->name }}</td>
                  <td>{{ $warehouse->location }}</td>
                  <td>
                    <x-show :action="route('warehouses.show', $warehouse)" />
                    <x-edit :action="route('warehouses.edit', $warehouse)" />
                    <x-delete-form :action="route('warehouses.destroy', $warehouse)" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">{{ __('No warehouses found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if ($warehouses->count())
        <div class="card-footer">
          @include('layouts.partials.pagination', ['page' => $warehouses])
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
