@extends('layouts.app')
@section('title')
    {{ __('Representatives list') }}
@endsection
{{-- @section('subTitle')
    {{ __('Representatives list') }}
@endsection --}}
@section('breadcrumb')
    {{ __('Representatives') }}
@endsection
@section('breadcrumbActive')
    {{ __('Representatives') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Representatives list') }}</h5>
                        <x-create :action="route('representatives.create')" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($representatives as $representative)
                                    <tr>
                                        <td>{{ $representative->id }}</td>
                                        <td>{{ $representative->name }}</td>
                                        <td>{{ $representative->email }}</td>
                                        <td>
                                        </td>
                                        <td>
                                            <x-show :action="route('representatives.show', $representative)" />
                                            <x-edit :action="route('representatives.edit', $representative)" />
                                            <x-delete-form :action="route('representatives.destroy', $representative)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No representatives found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($representatives->count())
                    <div class="card-footer">
                        @include('layouts.partials.pagination', ['page' => $representatives])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
