@extends((auth()->user()->level == 1) ? 'admin.layouts.app': 'layouts.app', ['title' => __('Reports'), 'page' => 'reports'])

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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Confirmed</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)($totalConfirmed), 2, '.', '') }} <small>USDT</small>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Pending</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)($totalPending), 2, '.', '') }} <small>USDT</small>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Grand Total</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)($total), 2, '.', '') }} <small>USDT</small>
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
                            <h3 class="col-12 mb-0">{{ __('Donations Received') }}</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableReceiveds" class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">From</th>
                                @if(auth()->user()->level == 1)
                                <th scope="col">Plan</th>
                                @endif
                                <th scope="col" class="text-center">
                                    @if(auth()->user()->level == 1)
                                        To
                                    @else
                                        To Your Plan
                                    @endif
                                </th>
                                <th scope="col" class="text-center">Donation Value</th>
                                <th scope="col" class="text-center">Hash</th>
                                <th scope="col" class="text-center">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($receives as $receive)
                                @if(!empty($receive->userPlan()))
                                    <tr>
                                        <td class="text-center notranslate">
                                            @if(!empty($receive->userPlan()))
                                                {{ $receive->userPlan()->user()->username }}
                                            @endif
                                        </td>
                                        @if(auth()->user()->level == 1)
                                        <td class="text-center">
                                            @if(!empty($receive->userPlan()))
                                                {{ substr(sha1($receive->userPlan()->id), -4) }}
                                            @endif
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            @if(auth()->user()->level == 1)
                                                @if(!empty($receive->user()))
                                                    {{ $receive->user()->username }}
                                                @endif
                                            @else
                                                @if(!empty($receive->donation()->userPlan()))
                                                    {{ substr(sha1($receive->donation()->userPlan()->id), -4) }}
                                                    @if($receive->donation()->userPlan()->is_20)
                                                    <span class="badge bg-primary text-white">2.0</span>
                                                    @endif
                                                @else
                                                    Bonus Receipt
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ $receive->value }} USDT
                                        </td>
                                        <td class="text-center">
                                            <span class="d-none">{{ $receive->hash }}</span>
                                            @if(!empty($receive->hash))
                                                <button type="submit" class="btn btn-sm btn-primary" id="copy{{ $receive->id }}" onclick="copyLink(this.id, '{{ $receive->hash }}')">
                                                    Copy Hash
                                                </button>
                                            @else    
                                                Waiting Payment
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ $receive->updated_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center d-none">
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
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        // Setup - add a text input to each footer cell
        $('#tableReceiveds thead tr').clone(true).appendTo( '#tableReceiveds thead' );
        $('#tableReceiveds thead tr:eq(1) th:not( :eq(5),:eq(6),:eq(7) )').each( function (i) {
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

        var table = $('#tableReceiveds').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pagingType: "full_numbers",
            "order": [[ $("#tableReceiveds").find('tr')[0].cells.length-1, "desc" ]],
            dom: 'lrtip',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
        } );
    </script>

    <script>
        function copyLink(id, hash) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = hash;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            $('#'+id).text('Copied');
            setTimeout(function(){ $('#'+id).text('Copy Hash'); }, 1000);
        }
    </script>
@endpush
