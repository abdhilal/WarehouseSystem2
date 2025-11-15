@extends('layouts.app')
@section('title')
    {{ __('Representative Medical details') }}
@endsection
@section('subTitle')
    {{ __('Representative Medical details') }}
@endsection
@section('breadcrumb')
    {{ __('Representatives Medical') }}
@endsection
@section('breadcrumbActive')
    {{ __('show') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Representative Medical details').' — '.$representative->name }}</h5>
                    <div>
                        <x-edit :action="route('representativesMedical.edit', $representative->id)" />
                        <x-back :action="route('representativesMedical.index')" />
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
                            <h3>{{ __('Representative Medical Transactions') }}</h3>
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
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('areas.show', $area) }}" class="text-decoration-none">
                                                {{ $area->name }}
                                            </a>
                                        </td>
                                        <td>{{ $area->warehouse?->name }}</td>
                                        <td>{{ number_format($area->transactions_sum_value_income ?? 0, 2) }}</td>
                                        <td>{{ number_format($area->transactions_sum_value_output ?? 0, 2) }}</td>
                                    </tr>
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
  document.addEventListener('DOMContentLoaded', function () {
    var options = {
      chart: {
        type: 'donut',
        width: 380
      },
      series: [
        {{ (float)($date['value_income'] ?? 0) }},
        {{ (float)($date['value_output'] ?? 0) }},
        {{ (float)($date['value_gift'] ?? 0) }}
      ],
      labels: [
        "{{ __('Value Income') }}",
        "{{ __('Value Output') }}",
        "{{ __('Gift Value') }}"
      ],
      legend: { position: 'bottom' },
      dataLabels: { enabled: true },
    };

    var chart = new ApexCharts(document.querySelector('#donutchart'), options);
    chart.render();

    var optionsPie = {
      chart: {
        type: 'pie',
        width: 380
      },
      series: [
        {{ (float)($date['quantity_product'] ?? 0) }},
        {{ (float)($date['quantity_gift'] ?? 0) }},
        {{ (float)($date['Wholesale_Sale'] ?? 0) }},
        {{ (float)($date['Wholesale_Return'] ?? 0) }}
      ],
      labels: [
        "{{ __('Quantity Product') }}",
        "{{ __('Quantity Gift') }}",
        "{{ __('Wholesale Sale') }}",
        "{{ __('Wholesale Return') }}"
      ],
      legend: { position: 'bottom' },
      dataLabels: { enabled: true },
    };

    var chartPie = new ApexCharts(document.querySelector('#piechart'), optionsPie);
    chartPie.render();
  });
</script>
@endpush
