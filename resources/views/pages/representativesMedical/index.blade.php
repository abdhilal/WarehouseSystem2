@extends('layouts.app')
@section('title')
    {{ __('Representatives Medical list') }}
@endsection
@section('subTitle')
    {{ __('Representatives Medical list') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives Medical') }}
@endsection
@section('breadcrumbActive')
    {{ __('Representatives Medical') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Representatives Medical list') }}</h5>
                        @can('create-representative')
                            <x-create :action="route('representativesMedical.create')" />
                        @endcan
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
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($representativesMedical as $index => $representative)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('representativesMedical.show', $representative) }}" class="text-decoration-none">
                                                {{ $representative->name }}
                                            </a>
                                        </td>
                                        <td>{{ $representative->warehouse?->name }}</td>
                                        <td>
                                            @can('show-representative')
                                                <x-show :action="route('representativesMedical.show', $representative)" />
                                            @endcan
                                            @can('edit-representative')
                                                <x-edit :action="route('representativesMedical.edit', $representative)" />
                                            @endcan
                                            @can('delete-representative')
                                                <x-delete-form :action="route('representatives.destroy', $representative)" />
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No representatives found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($representativesMedical->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $representativesMedical])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
