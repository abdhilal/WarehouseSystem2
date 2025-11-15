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
                            <h3>{{ __('Transactions') }} — {{ $date['date'] ?? '' }}</h3>
                        </div>
                        <div class="card-body apex-chart">
                            <div id="donutchart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6 box-col-6">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <h3>{{ __('Representative Medical Transactions') }} — {{ $date['date'] ?? '' }}</h3>
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
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($representative->pharmacies as $index => $pharmacy)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('pharmacies.show', $pharmacy) }}"
                                                class="text-decoration-none">
                                                {{ $pharmacy->name }}
                                            </a>
                                        </td>
                                        <td>{{ $pharmacy->area?->name }}</td>
                                        <td>{{ $pharmacy->warehouse?->name }}</td>
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
