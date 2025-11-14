@extends('layouts.app')
@section('title')
    {{ __('Files Manager') }}
@endsection
@section('subTitle')
    {{ __('Files') }}
@endsection
@section('breadcrumb')
    {{ __('Files') }}
@endsection
@section('breadcrumbActive')
    {{ __('Files') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Files Manager') }}</h5>
                        <div class="d-flex gap-2">

                            <x-create :action="route('files.upload')" />
                        </div>

                    </div>
                    <br>
                    <a href="{{ route('files.export') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i>
                        {{ __('Export') }}</a>

                </div>
                <div class="card-body">
                    <h4 class="mt-2 mb-3">{{ __('Files') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>{{ __('Month') }}</th>
                                    <th>{{ __('Year') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($files ?? []) as $index => $file)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $file->code }}</td>
                                        <td>{{ $file->month }}</td>
                                        <td>{{ $file->year }}</td>

                                        <td>
                                            @if (!empty($file->path))
                                                <a href="{{ route('files.download', $file->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa-solid fa-download"></i> {{ __('Download') }}
                                                </a>
                                            @endif
                                            <x-delete-form :action="route('files.destroy', $file)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No files found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
