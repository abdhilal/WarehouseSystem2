@extends('layouts.app')

@section('title', __('Dashboard'))
@section('subTitle', __('System Statistics'))
@section('breadcrumb', __('Home'))
@section('breadcrumbActive', __('Dashboard'))

@section('content')
    <div class="container-fluid">

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('dashboard') }}" class="card mb-3">
            <div class="card-body row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">{{ __('File') }}</label>
                    <select name="file_id" class="form-select">
                        <option value="" @selected($active_file_id === null)>{{ __('All') }}</option>
                        @foreach ($files as $f)
                            <option value="{{ $f->id }}" @selected($active_file_id == $f->id)>
                                {{ $f->code }} ({{ $f->month }}/{{ $f->year }})
                                @if ($f->is_default)
                                    - {{ __('Default') }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-4">
                    <button class="btn btn-primary">{{ __('Apply Filter') }}</button>
                </div>
            </div>
        </form>

        <div class="container-fluid dashboard-2">
            <div class="row row-cols-1 row-cols-xl-2 g-3">

                {{-- Transactions Summary --}}
                <div class="col">
                    <div class="card analytics-card card-fixed card-fixed-tall">
                        <div class="card-header card-no-border pb-0">

                        </div>

                        <div class="card card-fixed latest-transactions">
                            <div class="card-header card-no-border pb-0">
                                <h3>{{ __('Latest Transactions') }}</h3>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive theme-scrollbar">
                                    <table class="table table-striped align-middle display table-bordernone">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Pharmacy') }}</th>
                                                <th>{{ __('Representative') }}</th>

                                                <th>{{ __('Sales') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions->take(6) as $t)
                                                <tr>
                                                    <td>{{ $t->pharmacy?->name ?? __('غير محدد') }}</td>
                                                    <td>{{ $t->representative?->name ?? __('غير محدد') }}</td>
                                                    <td>{{ number_format($t->value_output, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    {{-- Sales Representatives --}}
                    <div class="col">
                        <div class="card card-fixed">
                            <div class="card-header card-no-border pb-0">
                                <h3>{{ __('Best Representatives (Sales)') }}</h3>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive theme-scrollbar">
                                    <table class="table display table-bordernone">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Representative') }}</th>
                                                <th>{{ __('Operations') }}</th>
                                                <th>{{ __('Returns') }}</th>
                                                <th>{{ __('Sales') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales_reps_stats->take(6) as $s)
                                                <tr>
                                                    <td>{{ $s['name'] }}</td>
                                                    <td>{{ $s['count'] }}</td>
                                                    <td class="font-primary f-w-600">{{ number_format($s['income'], 2) }}
                                                    </td>
                                                    <td>{{ number_format($s['output'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Entities Status --}}
                <div class="col">
                    <div class="card card-fixed card-fixed-half mb-4">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('Entities Status') }}</h3>
                        </div>
                        <div class="card-body pt-0 user-status">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Entity') }}</th>
                                            <th>{{ __('Count') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ __('Areas') }}</td>
                                            <td>
                                                <h3>{{ $summary['areas'] }}</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Pharmacies') }}</td>
                                            <td>
                                                <h3>{{ $summary['pharmacies'] }}</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Sales Representatives') }}</td>
                                            <td>
                                                <h3>{{ $summary['representatives_sales'] }}</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Medical Representatives') }}</td>
                                            <td>
                                                <h3>{{ $summary['representatives_medical'] }}</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Products') }}</td>
                                            <td>
                                                <h3>{{ $summary['products'] }}</h3>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Top Products --}}
                    <div class="card selling-product card-fixed card-fixed-half">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('Top Products') }}</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($grouped['by_product']->take(6) as $name => $stats)
                                    <li class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1">
                                            <h6>{{ $name }}</h6>
                                            <p>{{ __('Quantity') }}: {{ $stats['pieces'] }}</p>
                                        </div>
                                        <div class="recent-text">
                                            <h5>{{ number_format($stats['value_output'], 2) }}</h5>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>



                {{-- Medical Representatives --}}
                <div class="col">
                    <div class="card card-fixed">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('Best Representatives (Medical)') }}</h3>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Representative') }}</th>
                                            <th>{{ __('Operations') }}</th>
                                            <th>{{ __('Returns') }}</th>
                                            <th>{{ __('Sales') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medical_reps_stats->take(6) as $s)
                                            <tr>
                                                <td>{{ $s['name'] }}</td>
                                                <td>{{ $s['count'] }}</td>
                                                <td class="font-primary f-w-600">{{ number_format($s['income'], 2) }}</td>
                                                <td>{{ number_format($s['output'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- By Type --}}
                <div class="col">
                    <div class="card card-fixed">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('By Type') }}</h3>
                        </div>

                        <div class="card-body pt-0 user-status">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Count') }}</th>
                                            <th>{{ __('Returns') }}</th>
                                            <th>{{ __('Sales') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($by_type as $typeName => $s)
                                            <tr>
                                                <td>{{ $typeName }}</td>
                                                <td>
                                                    <h6>{{ $s['count'] }}</h6>
                                                </td>
                                                <td class="font-primary f-w-600">{{ number_format($s['income'], 2) }}</td>
                                                <td>{{ number_format($s['output'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- By Area --}}
                <div class="col">
                    <div class="card card-fixed">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('By Area') }}</h3>
                        </div>

                        <div class="table-responsive theme-scrollbar">
                            <table class="table display table-bordernone mt-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Area') }}</th>
                                        <th>{{ __('Operations') }}</th>
                                        <th>{{ __('Returns') }}</th>
                                        <th>{{ __('Sales') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($areas_summary->take(8) as $area)
                                        <tr>
                                            <td>{{ $area->name }}</td>
                                            <td>{{ $area->transactions_count }}</td>
                                            <td class="font-primary f-w-600">
                                                {{ number_format($area->transactions_sum_value_income, 2) }}</td>
                                            <td>{{ number_format($area->transactions_sum_value_output, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- By Pharmacy --}}
                <div class="col">
                    <div class="card card-fixed">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('By Pharmacy') }}</h3>
                            <ul class="simple-wrapper nav nav-pills">
                                <li class="nav-item"><span class="nav-link">{{ __('Income') }}:
                                        {{ number_format($summary['value_income'], 2) }}</span></li>
                                <li class="nav-item"><span class="nav-link active">{{ __('Output') }}:
                                        {{ number_format($summary['value_output'], 2) }}</span></li>
                            </ul>
                        </div>

                        <div class="table-responsive theme-scrollbar">
                            <table class="table display table-bordernone mt-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Pharmacy') }}</th>
                                        <th>{{ __('Operations') }}</th>
                                        <th>{{ __('Returns') }}</th>
                                        <th>{{ __('Sales') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grouped['by_pharmacy']->take(8) as $name => $s)
                                        <tr>
                                            <td>{{ $name }}</td>
                                            <td>{{ $s['count'] }}</td>
                                            <td class="font-primary f-w-600">{{ number_format($s['value_income'], 2) }}
                                            </td>
                                            <td>{{ number_format($s['value_output'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/dashboard/dashboard_2.js') }}"></script>
        <script>
            (function() {

                function updateSummary(summary) {
                    const list = document.querySelector('.analytics-card .simple-wrapper');
                    if (!list) return;

                    list.innerHTML =
                        `<li class="nav-item"><span class="nav-link">{{ __('Total') }}: ${summary.transactions}</span></li>
                 <li class="nav-item"><span class="nav-link">{{ __('Income') }}: ${Number(summary.value_income).toFixed(2)}</span></li>
                 <li class="nav-item"><span class="nav-link active">{{ __('Output') }}: ${Number(summary.value_output).toFixed(2)}</span></li>`;
                }

                function renderAreaChart(byArea) {
                    const el = document.getElementById('chart-school-performance');
                    if (!el || typeof ApexCharts === 'undefined') return;

                    const labels = Object.keys(byArea).slice(0, 8);
                    const income = labels.map(k => byArea[k].income);
                    const output = labels.map(k => byArea[k].output);

                    if (el._chart) el._chart.destroy();

                    const chart = new ApexCharts(el, {
                        chart: {
                            type: 'bar',
                            height: 320
                        },
                        series: [{
                                name: '{{ __('Income') }}',
                                data: income
                            },
                            {
                                name: '{{ __('Output') }}',
                                data: output
                            }
                        ],
                        xaxis: {
                            categories: labels
                        }
                    });

                    el._chart = chart;
                    chart.render();
                }

                function load() {
                    fetch('{{ route('dashboard.stats') }}?file_id={{ $active_file_id === null ? '' : $active_file_id }}&type={{ $active_type ?? '' }}', {
                            credentials: 'include'
                        })
                        .then(r => r.json())
                        .then(data => {
                            updateSummary(data.summary);
                            renderAreaChart(data.by_area);
                        })
                        .catch(console.error);
                }

                document.addEventListener('DOMContentLoaded', function() {
                    load();
                    setInterval(load, 30000);
                });

            })();
        </script>
    @endpush

    @push('styles')
        <style>
            .card-fixed {
                max-height: 420px;
                display: flex;
                flex-direction: column
            }

            .card-fixed-tall {
                max-height: 420px
            }

            .card-fixed-half {
                max-height: 210px
            }

            .card-fixed .card-header {
                flex: 0 0 auto
            }

            .card-fixed .card-body {
                flex: 1 1 auto;
                overflow: auto
            }

            .card-fixed h3 {
                font-size: 1rem
            }

            .card-fixed .table {
                font-size: .875rem
            }

            .analytics-card .statistic-num h5 {
                font-size: 1rem
            }

            .selling-product .recent-text h5 {
                font-size: 1rem
            }
        </style>
    @endpush

@endsection
