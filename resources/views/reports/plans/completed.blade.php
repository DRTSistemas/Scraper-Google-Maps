@extends('admin.layouts.app', ['title' => __('Reports'), 'page' => 'reports'])

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<style>
    .dataTables_length,
    .dataTables_filter {
        display: none;
    }
</style>
<style type="text/css">
    .dataTables_paginate a {
        padding: 10px !important;
    }
</style>
@endpush

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">All Completed Plans</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $totalAll }}
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
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Filtered Completed Plans</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $total }}
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
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Value of Filtered Plans</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)$plansValues, 2, '.', '') }} USDT
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
        <div class="row justify-content-center py-2">
            <div class="col-xl-6 col-lg-6">
                <form method="GET">
                    <div class="form-group text-center font-weight-bold text-white">
                        <label>Filter by DATE</label>
                        <div class="d-flex align-items-center">
                            <label class="mb-0 mx-2">From</label>
                            <input class="form-control" type="text" name="from" id="from" value="{{ $from }}">
                            <label class="mb-0 mx-2">To</label>
                            <input class="form-control" type="text" name="to" id="to" value="{{ $to }}">
                            <button type="submit" class="btn btn-sm btn-success ml-2">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Completed Plans') }}</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableCompleted" class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">Plan</th>
                                <th scope="col" class="text-center">Username</th>
                                <th scope="col" class="text-center">Plan Value</th>
                                <th scope="col" class="text-center">End Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <th class="text-center">
                                        {{ substr(sha1($donation->id), -4) }}
                                    </th>
                                    <td class="text-center notranslate">
                                        {{ $donation->user()->username }}      
                                    </td>
                                    <td class="text-center notranslate">
                                        {{ $donation->plan()->plan_value }} USDT
                                    </td>
                                    <td class="text-center notranslate">
                                        {{ $donation->updated_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-4 order-xl-2 mb-5 my-5">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0 p-3">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Per Day') }}</h3>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive" style="overflow-x: hidden;">
                            <table class="table align-items-center table-flush">
                                <tbody>
                                    @foreach($donationsPerDay as $key => $day)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <th>{{ number_format((float)($day), 2, '.', '') }} USDT</th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 order-xl-2 mb-5 my-5">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('By Plan Value') }}</h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive" style="overflow-x: hidden;">
                            <table class="table align-items-center table-flush">
                                <tbody>
                                    @foreach($byValue as $key => $value)
                                    <tr>
                                        <th>Plan: {{ $key }} USDT</th>
                                        <th>Total ({{ $value / $key }}): {{ number_format((float)$value, 2, '.', '') }} USDT</th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>


    <script>
        // Setup - add a text input to each footer cell
        $('#tableCompleted thead tr').clone(true).appendTo( '#tableCompleted thead' );
        $('#tableCompleted thead tr:eq(1) th:not( :eq(2),:eq(3) )').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            } );
        } );

        var table = $('#tableCompleted').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pagingType: "full_numbers",
            "order": [[ 3, "desc" ]],
            dom: 'lrtip',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
        } );
    </script>
    @endpush
