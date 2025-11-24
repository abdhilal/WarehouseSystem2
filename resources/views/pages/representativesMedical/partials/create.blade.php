@extends('layouts.app')
@section('title')
    {{ __('add new representative medical') }}
@endsection
@section('subTitle')
    {{ __('add new representative medical') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives Medical') }}
@endsection
@section('breadcrumbActive')
    {{ __('add new representative medical') }}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ __('Create Representative Medical') }}</h5>
        </div>
        <div class="card-body">
          <x-form :action="route('representativesMedical.store')" method="POST" class="row g-3" novalidate>
            <x-input name="name" label="{{ __('Name') }}" required col="6" />
            <div class="form-group col-sm-6 col-md-4">
              <label>{{ __('Areas') }}</label>
              <div class="border rounded p-2" style="max-height: 180px; overflow-y: auto;">
                @foreach($areas as $area)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="area_ids[]" id="area_{{ $area->id }}" value="{{ $area->id }}" @checked(collect(old('area_ids', []))->contains($area->id)) >
                    <label class="form-check-label" for="area_{{ $area->id }}">{{ $area->name }}</label>
                  </div>
                @endforeach
              </div>
              <small class="text-muted">{{ __('Select one or more areas') }}</small>
            </div>
            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
              <x-cancel route="representativesMedical.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
