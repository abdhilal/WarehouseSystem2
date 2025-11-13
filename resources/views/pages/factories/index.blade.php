@extends('layouts.app')
@section('title')
    {{ __('Factories list') }}
@endsection
@section('subTitle')
    {{ __('Factories list') }}
@endsection
@section('breadcrumb')
    {{ __('Factories') }}
@endsection
@section('breadcrumbActive')
    {{ __('Factories') }}
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5>{{ __('Factories list') }}</h5>
          <x-create :action="route('factories.create')" />
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($factories as $index => $factory)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $factory->name }}</td>
                  <td>
                    <x-show :action="route('factories.show', $factory)" />
                    <x-edit :action="route('factories.edit', $factory)" />
                    <x-delete-form :action="route('factories.destroy', $factory)" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">{{ __('No factories found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if ($factories->count())
        <div class="card-footer">
          @include('layouts.partials.pagination', ['page' => $factories])
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
