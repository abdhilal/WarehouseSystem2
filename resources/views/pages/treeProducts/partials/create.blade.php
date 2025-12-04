@extends('layouts.app')
@section('title')
    {{ __('Upload Tree Products') }}
@endsection
@section('subTitle')
    {{ __('Tree Products') }}
@endsection
@section('breadcrumb')
    {{ __('Tree Products') }}
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
          <h5 class="mb-0">{{ __('Upload Tree Products') }}</h5>
          <a href="{{ route('TreeProducts.export') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> {{ __('Export') }}</a>
        </div>
        <div class="card-body">
          <div id="uploadProgress" class="mb-3" style="display:none;">
            <div class="d-flex justify-content-between mb-1">
              <span id="uploadStatus">{{ __('Uploading') }}</span>
              <span id="uploadPercent">0%</span>
            </div>
            <div class="progress">
              <div class="progress-bar" id="uploadBar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <x-form id="tree-upload-form" :action="route('TreeProducts.store')" method="POST" enctype="multipart/form-data" class="row g-3" novalidate>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  var form = document.getElementById('tree-upload-form');
  if(!form) return;
  var action = form.getAttribute('action');
  var method = (form.getAttribute('method') || 'POST').toUpperCase();
  var bar = document.getElementById('uploadBar');
  var pctEl = document.getElementById('uploadPercent');
  var cont = document.getElementById('uploadProgress');
  var statusEl = document.getElementById('uploadStatus');
  var submitBtn = form.querySelector('button[type="submit"]');
  form.addEventListener('submit', function(e){
    e.preventDefault();
    var fd = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open(method, action, true);
    cont.style.display = 'block';
    statusEl.textContent = "{{ __('Uploading') }}";
    bar.classList.remove('progress-bar-striped','progress-bar-animated');
    if (submitBtn) submitBtn.disabled = true;
    xhr.upload.onprogress = function(ev){
      if(ev.lengthComputable){
        var pct = Math.round((ev.loaded / ev.total) * 100);
        bar.style.width = pct + '%';
        pctEl.textContent = pct + '%';
      } else {
        bar.classList.add('progress-bar-striped','progress-bar-animated');
        pctEl.textContent = '';
      }
    };
    xhr.upload.onload = function(){
      statusEl.textContent = "{{ __('Processing...') }}";
      bar.classList.add('progress-bar-striped','progress-bar-animated');
      pctEl.textContent = '';
    };
    xhr.onload = function(){
      if (submitBtn) submitBtn.disabled = false;
      bar.classList.remove('progress-bar-striped','progress-bar-animated');
      if(xhr.status >= 200 && xhr.status < 300){
        try { localStorage.setItem('flash_success', "{{ __('Tree Products uploaded successfully') }}"); } catch(e) {}
        window.location.href = "{{ route('TreeProducts.index') }}";
      } else {
        try { localStorage.setItem('flash_error', "{{ __('Upload failed') }}"); } catch(e) {}
        alert("{{ __('Upload failed') }}");
      }
    };
    xhr.onerror = function(){
      if (submitBtn) submitBtn.disabled = false;
      alert("{{ __('Network error') }}");
    };
    xhr.send(fd);
  });
});
</script>
@endpush
