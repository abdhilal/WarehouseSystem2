@extends('layouts.app')
@section('title')
    {{ __('Representative details') }}
@endsection
@section('subTitle')
    {{ __('Representative details') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Representative details') . ' — ' . $representative->name }}</h5>
                    <div>
                        <x-back :action="route('representatives.index')" />
                    </div>
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
                <div class="row">
                    <div class="col-sm-12 col-xl-6 box-col-6">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                                <h3>{{ __('Transactions') }}</h3>
                            </div>
                            <div class="card-body apex-chart">
                                <div id="donutchart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6 box-col-6">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                                <h3>{{ __('Transactions') }}</h3>
                            </div>
                            <div class="card-body apex-chart">
                                <div id="piechart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <td>{{ $representative->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $representative->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Areas') }}</th>
                                    <td>
                                        @foreach ($areas as $area)
                                            {{ $area->name }} -
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Warehouse') }}</th>
                                    <td>{{ $representative->warehouse?->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr />
                    <h5 class="mt-4 mb-3">{{ __('Pharmacies') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Value Income') }}</th>
                                    <th>{{ __('Value Output') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pharmacies as $index => $pharmacy)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('pharmacies.show', $pharmacy) }}"
                                                class="text-decoration-none">
                                                {{ $pharmacy->name }}
                                            </a>
                                        </td>
                                        <td>{{ $pharmacy->area?->name }}</td>
                                        <td>{{ number_format($pharmacyTotals[$pharmacy->id]['income'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($pharmacyTotals[$pharmacy->id]['output'] ?? 0, 2) }}</td>
                                        <td>
                                            <x-show :action="route('pharmacies.show', $pharmacy)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">{{ __('No pharmacies found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-4 mb-3">{{ __('Areas') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('Value Income') }}</th>
                                    <th>{{ __('Value Output') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($areas as $index => $area)
                                    @if ($area->income_sum > 0 || $area->output_sum > 0)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('areas.show', $area) }}" class="text-decoration-none">
                                                    {{ $area->name }}
                                                </a>
                                            </td>
                                            <td>{{ $area->warehouse?->name }}</td>
                                            <td>{{ number_format($area->income_sum ?? 0, 2) }}</td>
                                            <td>{{ number_format($area->output_sum ?? 0, 2) }}</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5">{{ __('No areas found') }}</td>
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
            function getThemeTextColor() {
                var cs = getComputedStyle(document.body);
                var v = cs.getPropertyValue('--body-font-color');
                return v && v.trim() ? v.trim() : '#222';
            }
            var labelColor = getThemeTextColor();
            var options = {
                chart: {
                    type: 'donut',
                    width: 380
                },
                series: [
                    {{ (float) ($date['value_income'] ?? 0) }},
                    {{ (float) ($date['value_output'] ?? 0) }},
                    {{ (float) ($date['value_gift'] ?? 0) }}
                ],
                labels: [
                    "{{ __('Value Income') }}",
                    "{{ __('Value Output') }}",
                    "{{ __('Gift Value') }}"
                ],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                tooltip: {
                    y: {
                        formatter: formatNumber
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector('#donutchart'), options);
            chart.render();

            var optionsPie = {
                chart: {
                    type: 'pie',
                    width: 380
                },
                series: [
                    {{ (float) ($date['quantity_product'] ?? 0) }},
                    {{ (float) ($date['quantity_gift'] ?? 0) }},
                    {{ (float) ($date['Wholesale_Sale'] ?? 0) }},
                    {{ (float) ($date['Wholesale_Return'] ?? 0) }}
                ],
                labels: [
                    "{{ __('Quantity Product') }}",
                    "{{ __('Quantity Gift') }}",
                    "{{ __('Wholesale Sale') }}",
                    "{{ __('Wholesale Return') }}"
                ],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                tooltip: {
                    y: {
                        formatter: formatNumber
                    }
                },
            };

            var chartPie = new ApexCharts(document.querySelector('#piechart'), optionsPie);
            chartPie.render();

            var barData = @json($summary);
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
            document.getElementById('rep-bar-chart').style.minWidth = chartWidth + 'px';

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
                    width: chartWidth,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        endingShape: 'rounded',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0],
                    formatter: formatNumber,
                    offsetY: -25,
                    style: { fontSize: '10px', colors: [labelColor] }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories
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
            var observer = new MutationObserver(function() {
                labelColor = getThemeTextColor();
                barChart.updateOptions({ dataLabels: { style: { colors: [labelColor] } } });
            });
            observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
@endpush
