@extends('layouts.app')
@section('title')
    {{ __('Areas list') }}
@endsection
@section('subTitle')
    {{ __('Areas list') }}
@endsection
@section('breadcrumb')
    {{ __('Areas') }}
@endsection
@section('breadcrumbActive')
    {{ __('Areas') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Areas list') }}</h5>
          <x-create :action="route('areas.create')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Warehouse') }}</th>
                <th>{{ __('Total Income') }}</th>
                <th>{{ __('Total Output') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($areas as $index => $area)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $area->name }}</td>
                  <td>{{ $area->warehouse?->name }}</td>
                  <td>{{ $area->transactions_sum_value_income }}</td>
                  <td>{{ $area->transactions_sum_value_output }}</td>
                  <td>
                    <x-show :action="route('areas.show', $area)" />
                    <x-edit :action="route('areas.edit', $area)" />
                    <x-delete-form :action="route('areas.destroy', $area)" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">{{ __('No areas found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if ($areas->count())
        <div class="card-footer">
          @include('layouts.partials.pagination', ['page' => $areas])
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
