@extends('layouts.app')
@section('title')
    {{ __('Area details') }}
@endsection


@section('subTitle')
    {{ __('Area details') }}
@endsection
@section('breadcrumb')
    {{ __('Areas') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Area details') }}</h5>
                    <div>
                        <x-back :action="route('areas.index')" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <td>{{ $area->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $area->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Warehouse') }}</th>
                                    <td>{{ $area->warehouse?->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header card-no-border pb-0">
                                    <h3>{{ __('Work Summary') }}</h3>
                                </div>
                                <div class="card-body apex-chart" style="overflow-x: auto; overflow-y: hidden; width: 90%;">
                                    <div id="rep-bar-chart" style="min-width: 800px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ $stats['transactions_count'] ?? 0 }}</div>
                                    <div class="text-muted">{{ __('Transactions') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_income'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Value Income') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_output'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Value Output') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="h5 mb-1">{{ number_format($stats['value_gift'] ?? 0, 2) }}</div>
                                    <div class="text-muted">{{ __('Gift Value') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-3">{{ __('Representatives') }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($area->representatives as $index => $rep)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ $rep->type == 'medical' ? route('representativesMedical.show', $rep) : route('representatives.show', $rep) }}"
                                                class="text-decoration-none">{{ $rep->name }}</a></td>
                                        <td>{{ __($rep->type) }}</td>
                                        <td>{{ $rep->warehouse?->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No representatives found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-2 mb-3">{{ __('Pharmacies') }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Representative') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($area->pharmacies as $index => $pharmacy)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ route('pharmacies.show', $pharmacy) }}"
                                                class="text-decoration-none">{{ $pharmacy->name }}</a></td>
                                        <td><a href="{{ route('representatives.show', $pharmacy->representative) }}"
                                                class="text-decoration-none">{{ $pharmacy->representative?->name }}</a>
                                        </td>
                                        <td>{{ $pharmacy->warehouse?->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No pharmacies found') }}</td>
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
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatNumber(val) {
                return Number(val).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            var barData = @json($stats['summary'] ?? []);
            var items = Object.values(barData).sort(function(a, b) {
                return new Date(b.date) - new Date(a.date);
            });
            var categories = items.map(function(d) {
                return d.date;
            });
            var incomeSeries = items.map(function(d) {
                return parseFloat(d.value_income || 0);
            });
            var outputSeries = items.map(function(d) {
                return parseFloat(d.value_output || 0);
            });
            var chartWidth = Math.max((categories.length || 1) * 100, 800);
            var chartEl = document.querySelector('#rep-bar-chart');
            if (chartEl) chartEl.style.minWidth = chartWidth + 'px';

            var barOptions = {
                series: [{
                        name: "{{ __('Value Output') }}",
                        data: outputSeries
                    },
                    {
                        name: "{{ __('Value Income') }}",
                        data: incomeSeries
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 380,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories,
                    tickPlacement: 'on'
                },
                grid: {
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
                yaxis: {
                    labels: {
                        formatter: formatNumber
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: ['#51bb25', '#ff3a3a'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: formatNumber
                    }
                }
            };

            var barChart = new ApexCharts(document.querySelector('#rep-bar-chart'), barOptions);
            barChart.render();

            setTimeout(function() {
                var sc = document.querySelector('#rep-bar-chart');
                if (sc && sc.parentElement) sc.parentElement.scrollLeft = sc.parentElement.scrollWidth;
            }, 100);
        });
    </script>
@endpush
