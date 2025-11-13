@extends('layouts.app')

@section('title', __('Pharmacies'))
@section('content')
<div class="col-12">
  <div class="card shadow mb-4">
    <div class="card-header">
      <strong class="card-title">{{ __('Pharmacy Details') }}</strong>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input type="text" class="form-control" value="{{ $pharmacy->name }}" readonly>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>{{ __('Warehouse') }}</label>
            <input type="text" class="form-control" value="{{ $pharmacy->warehouse?->name }}" readonly>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>{{ __('Area') }}</label>
            <input type="text" class="form-control" value="{{ $pharmacy->area?->name }}" readonly>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>{{ __('Representative') }}</label>
            <input type="text" class="form-control" value="{{ $pharmacy->representative?->name }}" readonly>
          </div>
        </div>
      </div>
      <a href="{{ route('pharmacies.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
    </div>
  </div>
</div>
@endsection