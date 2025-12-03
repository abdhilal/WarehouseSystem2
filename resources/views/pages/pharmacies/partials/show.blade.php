@extends('layouts.app')
@section('title')
    {{ __('Pharmacy details') }}
@endsection
@section('subTitle')
    {{ __('Pharmacy details') }}
@endsection
@section('breadcrumb')
    {{ __('Pharmacies') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Pharmacy details') }}</h5>
                    <div>
                        <x-back :action="route('pharmacies.index')" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <td>{{ $pharmacy->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $pharmacy->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Warehouse') }}</th>
                                    <td>{{ $pharmacy->warehouse?->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Area') }}</th>
                                    <td>{{ $pharmacy->area?->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Representative') }}</th>
                                    <td>{{ $pharmacy->representative?->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h3 mb-0">{{ $stats['transactions_count'] ?? 0 }}</div>
                                        <div class="text-title-gray">{{ __('Transactions') }}</div>
                                    </div>
                                    <i class="fa-solid fa-receipt text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h3 mb-0">{{ number_format($stats['value_income'] ?? 0, 2) }}</div>
                                        <div class="text-title-gray">{{ __('Value Income') }}</div>
                                    </div>
                                    <i class="fa-solid fa-arrow-down text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h3 mb-0">{{ number_format($stats['value_output'] ?? 0, 2) }}</div>
                                        <div class="text-title-gray">{{ __('Value Output') }}</div>
                                    </div>
                                    <i class="fa-solid fa-arrow-up text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h3 mb-0">{{ number_format($stats['value_gift'] ?? 0, 2) }}</div>
                                        <div class="text-title-gray">{{ __('Gift Value') }}</div>
                                    </div>
                                    <i class="fa-solid fa-gift text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <h5 class="mt-2 mb-3">{{ __('Transactions') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Representative') }}</th>
                                    <th>{{ __('Value Income') }}</th>
                                    <th>{{ __('Value Output') }}</th>
                                    <th>{{ __('Gift Value') }}</th>
                                    <th>{{ __('Quantity Gift') }}</th>
                                    <th>{{ __('Quantity Product') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $t)
                                    <tr>
                                        <td>{{ $t->id }}</td>
                                        <td>{{ __($t->type) }}</td>
                                        <td>{{ $t->product?->name }}</td>
                                        <td>{{ $t->representative?->name }}</td>
                                        <td>{{ number_format($t->value_income ?? 0, 2) }}</td>
                                        <td>{{ number_format($t->value_output ?? 0, 2) }}</td>
                                        <td>{{ number_format($t->value_gift ?? 0, 2) }}</td>
                                        <td>{{ $t->quantity_gift ?? ' ' }}</td>
                                        <td>{{ $t->quantity_product ?? ' ' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">{{ __('No transactions found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($transactions->count())
                        @include('layouts.partials.pagination', ['page' => $transactions])
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
