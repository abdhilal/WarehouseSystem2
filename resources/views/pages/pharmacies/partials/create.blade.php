@extends('layouts.app')

@section('title', __('Pharmacies'))
@section('content')
<div class="col-12">
  <div class="card shadow mb-4">
    <div class="card-header">
      <strong class="card-title">{{ __('Create Pharmacy') }}</strong>
    </div>
    <div class="card-body">
      <form action="{{ route('pharmacies.store') }}" method="POST">
        @if ($errors->any())
          <div class="alert alert-danger mb-3">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label for="warehouse_id">{{ __('Warehouse') }}</label>
            <select name="warehouse_id" id="warehouse_id" class="form-control" required>
              <option value="">{{ __('Choose...') }}</option>
              @foreach($warehouses as $warehouse)
                <option value="{{ $warehouse->id }}" @selected(old('warehouse_id') == $warehouse->id)>{{ $warehouse->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="area_id">{{ __('Area') }}</label>
            <select name="area_id" id="area_id" class="form-control" required>
              <option value="">{{ __('Choose...') }}</option>
              @foreach($areas as $area)
                <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>{{ $area->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="representative_id">{{ __('Representative') }}</label>
            <select name="representative_id" id="representative_id" class="form-control">
              <option value="">{{ __('Choose...') }}</option>
              @foreach($representatives as $rep)
                <option value="{{ $rep->id }}" @selected(old('representative_id') == $rep->id)>{{ $rep->name }} ({{ $rep->email }})</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection