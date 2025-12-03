@extends('layouts.app')
@section('title')
    {{ __('Tree Products') }}
@endsection
@section('subTitle')
    {{ __('Tree Products') }}
@endsection
@section('breadcrumb')
    {{ __('Tree Products') }}
@endsection
@section('breadcrumbActive')
    {{ __('Tree Products') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ __('Tree Products') }}</h5>


                    </div>
                    <br>
                    <div>
                        <a href="{{ route('TreeProducts.export') }}" class="btn btn-outline-primary"><i
                                class="iconly-Upload icli"></i>
                            {{ __('Export') }}</a>


                        <a href="{{ route('TreeProducts.upload') }}" class="btn btn-outline-success"><i
                                class="fa-solid fa-download"></i>
                            {{ __('Import') }}</a>
                            <a href="{{ route('TreeProducts.Management') }}" class="btn btn-outline-info"><i
                                    class="fa-solid fa-gear"></i>
                                {{ __('Management') }}</a>
                    </div>

                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('TreeProducts.index') }}" class="card mb-3">
                        <div class="card-body row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Date') }}</label>
                                <select name="date" class="form-select">
                                    <option value="" @selected(empty($date))>{{ __('All') }}</option>
                                    @foreach ($dates as $d)
                                        <option value="{{ $d }}" @selected(($date ?? '') == $d)>
                                            {{ $d }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('Search') }}</label>
                                <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" placeholder="{{ __('Name') }}" />
                            </div>

                            <div class="col-md-4 d-flex gap-2">
                                <button class="btn btn-primary">{{ __('Apply Filter') }}</button>
                                <a href="{{ route('TreeProducts.index') }}" class="btn btn-outline-secondary">{{ __('Clear') }}</a>
                            </div>
                        </div>
                    </form>
                    <h4 class="mt-2 mb-3">{{ __('Tree Products') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Bonus') }}</th>
                                    <th>{{ __('Regular price') }}</th>
                                    <th>{{ __('General price') }}</th>
                                    <th>{{ __('Wholesale price') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($treeProducts) as $index => $treeProduct)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $treeProduct->name }}</td>
                                        <td>{{ $treeProduct->quantity }}</td>
                                        <td>{{ $treeProduct->Bonus2 }}+{{ $treeProduct->Bonus1 }}</td>
                                        <td>{{ $treeProduct->Regular_price }}</td>
                                        <td>{{ $treeProduct->General_price }}</td>
                                        <td>{{ $treeProduct->wholesale_price }}</td>

                                        <td>
                                            {{ $treeProduct->month_year }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6">{{ __('No tree products found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($treeProducts->count())
                        <div class="card-footer">
                            @include('layouts.partials.pagination', ['page' => $treeProducts])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
