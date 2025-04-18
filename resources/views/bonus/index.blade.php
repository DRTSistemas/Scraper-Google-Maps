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
                <div class="row justify-content-center align-items-center mb-0 mb-lg-3">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Pending</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)$totalPending, 2, '.', '') }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-dollar-sign"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Confirmed</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $totalConfirmed }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-money-check-alt"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Requesting</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)$request, 2, '.', '') }} <small>USDT</small>
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end align-items-center">
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
                                            {{ $total + auth()->user()->earnings_master + auth()->user()->earnings_diamond }} <small>USDT</small>
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
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-xl-9 order-xl-2 mb-5 mb-xl-0">
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
                                            <th scope="col" class="text-center">Plan</th>
                                            <th scope="col" class="text-center">Value</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Generated at</th>
                                            <th scope="col" class="text-center">Requested at</th>
                                            <th scope="col" class="text-center">Received at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                            @foreach($saques as $s)
                                                @if($report->id == $s->id)
                                                    <tr>
                                                        <td class="p-0 border-0" colspan="7">
                                                            @if($s->status == 1)
                                                                <span class="badge badge-pill badge-warning w-100 rounded-0 py-3" style="font-size: 12px; text-aling: center; letter-spacing: 2px; font-weight: bold; background-color: rgba(147, 231, 195, .5) !important; color: red !important;">
                                                            @else
                                                                <span class="badge badge-pill badge-success  w-100 rounded-0 py-3" style="font-size: 12px; text-aling: center; letter-spacing: 2px; font-weight: bold; background-color: rgb(53 227 255 / 50%) !important; color: red !important;">
                                                            @endif
                                                                Withdrawal requested on the day {{ $s->updated_at->format('j F, Y') }} with the value:  <span style="color: red;"> {{ $reports_paginate->where('updated_at', $s->updated_at)->sum('value') }} USDT </span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <tr class="text-center">
                                                <th class="text-center">
                                                    @if(is_null($report->plan_id))
                                                        {{ $report->transaction()->userPlan()->user()->username }}
                                                    @else
                                                        {{ $report->description }}
                                                    @endif
                                                </th>
                                                <th class="text-center">
                                                    @if(is_null($report->plan_id))
                                                        {{ substr(sha1($report->transaction()->userPlan()->id), -4) }}
                                                    @else
                                                        @if($report->plan_id > 0)
                                                            {{ substr(sha1($report->plan_id), -4) }}
                                                        @endif
                                                    @endif
                                                    @if($report->is_20)
                                                        <span class="badge bg-primary text-white">2.0</span>
                                                    @endif
                                                </th>
                                                <td class="text-center">
                                                    {{ number_format(($report->value), 2) }} USDT
                                                </td>
                                                @if($report->status == 0)
                                                    <th  class="text-center">
                                                        Generated
                                                    </th>
                                                @elseif($report->status == 1)
                                                    <th  class="text-center text-warning">
                                                        Waiting Payment
                                                    </th>
                                                @elseif($report->status == 2)
                                                    <th  class="text-center text-success">
                                                        Confirmed
                                                    </th>
                                                @else
                                                    <th  class="text-center text-danger">
                                                        Canceled
                                                    </th>
                                                @endif
                                                <td class="text-center notranslate">
                                                    {{ $report->created_at->format('Y-m-d') }}
                                                </td>
                                                @if($report->status != 0)
                                                    <td class="text-center notranslate">
                                                        @if(isset($report->requested))
                                                        {{ $report->requested->created_at->format('Y-m-d') }}
                                                        @else
                                                        {{ $report->updated_at->format('Y-m-d') }}
                                                        @endif
                                                    </td>
                                                    @if($report->status == 2)
                                                    <td class="text-center notranslate">
                                                        @if(isset($report->requested))
                                                        {{ $report->requested->updated_at->format('Y-m-d') }}
                                                        @else
                                                        {{ $report->updated_at->format('Y-m-d') }}
                                                        @endif
                                                    </td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $reports->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0 p-2">
                        <div class="row align-items-center">
                            <h4 class="col-12 text-center mb-0">{{ __('Request payment') }}</h4>
                        </div>
                    </div>
                    <div class="card-body text-center p-3">
                        <h1 class="text-center" style="font-size: 25px;">
                            {{ $request }} <small>USDT</small>
                        </h1>
                        @if($request >= $config['min_bonus_request'])
                            <form method="post" action="{{ route('bonus.store') }}">
                                @csrf

                                <button type="submit" class="btn btn-block btn-sm btn-success">Request</button>
                            </form>
                        @else
                            <button class="btn btn-block btn-sm btn-success" disabled>Request</button>
                            <small>Minimum to request bonus is {{ $config['min_bonus_request'] }} USDT</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
