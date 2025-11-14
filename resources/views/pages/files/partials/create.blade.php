@extends('layouts.app')
@section('title')
    {{ __('Upload File') }}
@endsection
@section('subTitle')
    {{ __('Files') }}
@endsection
@section('breadcrumb')
    {{ __('Files') }}
@endsection
@section('breadcrumbActive')
    {{ __('add new') }}
@endsection
@section('content')
@php
    $monthsOptions = array_combine(range(1, 12), range(1, 12));
    $currentYear = now()->year;
    $yearsRange = range($currentYear, $currentYear - 30);
    $yearsOptions = array_combine($yearsRange, $yearsRange);
@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ __('Upload File') }}</h5>
          <a href="{{ route('files.export') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> {{ __('Export') }}</a>
        </div>
        <div class="card-body">
          <x-form :action="route('files.store')" method="POST" enctype="multipart/form-data" class="row g-3" novalidate>
            <x-select name="month" label="{{ __('Month') }}" :options="$monthsOptions" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-select name="year" label="{{ __('Year') }}" :options="$yearsOptions" placeholder="{{ __('Choose...') }}" col="6" required />
            <x-input name="file" type="file" label="{{ __('File') }}" required col="12" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
              <x-cancel route="files.index" />
            </div>
          </x-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
