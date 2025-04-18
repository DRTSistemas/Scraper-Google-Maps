@extends('layouts.app', ['title' => __('Bonus'), 'page' => 'bonus'])

@push('styles')
    <style>
        .card .table td, .card .table th {
                padding-right: .3rem !important;
                padding-left: .3rem !important;
        }
    </style>
@endpush

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                @if(auth()->user()->is_leader > 0)
                <div class="row justify-content-center align-items-center mb-3">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Master Earnings</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ auth()->user()->earnings_master }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape text-white rounded-circle shadow">
                                            <img src="{{ asset('img/master.png') }}" width="50px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Diamond Earnings</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ auth()->user()->earnings_diamond }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape text-white rounded-circle shadow">
                                            <img src="{{ asset('img/diamond.png') }}" width="50px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)auth()->user()->earnings_diamond + auth()->user()->earnings_master, 2, '.', '') }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                    <div class="row">
                                <div class="col-6">
                                    <h3 class="col-12 mb-0" style="padding-bottom: 20px;">{{ __('History') }}</h3>
                                </div>
                            </div>
                        <div class="row align-items-center">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">From</th>
                                            <th scope="col" class="text-center">Plan Value</th>
                                            <th scope="col" class="text-center">Value Comission</th>
                                            <th scope="col" class="text-center">Generated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($keys[0]))
                                        <tr>
                                             <td class="p-0 border-0" colspan="4">
                                                <span class="d-flex justify-content-around badge badge-pill badge-success  w-100 rounded-0 py-3" style="font-size: 12px; text-aling: center; letter-spacing: 2px; font-weight: bold; background-color: rgb(53 227 255 / 50%) !important; color: red !important;">
                                                    <span>Month: {{ $keys[0] }}</span>
                                                    <span>Activations:  {{ number_format((float)$totalSales[ $keys[0]], 2, '.', '') }} USDT</span>
                                                    <span>Award: {{ number_format((float)$totalSales[ $keys[0]] * (5 / 100), 2, '.', '') }} USDT</span>
                                                </span>
                                            </td>
                                        </tr>

                                        @foreach($reports[$keys[0]] as $key => $report)
                                            <tr class="text-center">
                                                <th class="text-center">
                                                    {{ $report->user()->username }}
                                                </th>
                                                <th class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value), 2) }} USDT
                                                </th>
                                                <td class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value * (5 / 100)), 2) }} USDT
                                                </td>
                                                <td class="text-center notranslate">
                                                    {{ $report->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif

                                        @if(isset($keys[1]))
                                        <tr>
                                             <td class="p-0 border-0" colspan="4">
                                                <span class="d-flex justify-content-around badge badge-pill badge-success  w-100 rounded-0 py-3" style="font-size: 12px; text-aling: center; letter-spacing: 2px; font-weight: bold; background-color: rgb(53 227 255 / 50%) !important; color: red !important;">
                                                    <span>Month: {{ $keys[1] }}</span>
                                                    <span>Activations:  {{ number_format((float)$totalSales[ $keys[1]], 2, '.', '') }} USDT</span>
                                                    <span>Award: {{ number_format((float)$totalSales[ $keys[1]] * (5 / 100), 2, '.', '') }} USDT</span>
                                                </span>
                                            </td>
                                        </tr>

                                        @foreach($reports[$keys[1]] as $key => $report)
                                            <tr class="text-center">
                                                <th class="text-center">
                                                    {{ $report->user()->username }}
                                                </th>
                                                <th class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value), 2) }} USDT
                                                </th>
                                                <td class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value * (5 / 100)), 2) }} USDT
                                                </td>
                                                <td class="text-center notranslate">
                                                    {{ $report->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif

                                        @if(isset($keys[2]))
                                        <tr>
                                             <td class="p-0 border-0" colspan="4">
                                                <span class="d-flex justify-content-around badge badge-pill badge-success  w-100 rounded-0 py-3" style="font-size: 12px; text-aling: center; letter-spacing: 2px; font-weight: bold; background-color: rgb(53 227 255 / 50%) !important; color: red !important;">
                                                    <span>Month: {{ $keys[2] }}</span>
                                                    <span>Activations:  {{ number_format((float)$totalSales[ $keys[2]], 2, '.', '') }} USDT</span>
                                                    <span>Award: {{ number_format((float)$totalSales[ $keys[2]] * (5 / 100), 2, '.', '') }} USDT</span>
                                                </span>
                                            </td>
                                        </tr>

                                        @foreach($reports[$keys[2]] as $key => $report)
                                            <tr class="text-center">
                                                <th class="text-center">
                                                    {{ $report->user()->username }}
                                                </th>
                                                <th class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value), 2) }} USDT
                                                </th>
                                                <td class="text-center">
                                                    {{ number_format(floatval($report->plan()->plan_value * (5 / 100)), 2) }} USDT
                                                </td>
                                                <td class="text-center notranslate">
                                                    {{ $report->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection