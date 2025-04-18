@extends('admin.layouts.app', ['title' => __('Payment Diamonds'), 'page' => 'payment'])

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <style>
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush

@section('content')
    @include('users.partials.header', [
        'title' => '',
        'description' => '',
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--7">
        <!-- Card stats -->
        <div class="row justify-content-center mb-3">
            <div class="col-xl-4 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total in Activations in the month</h5>
                                <span class="h2 font-weight-bold mb-0">
                                    {{ number_format((float)$made, 2, '.', '') }} <small>USDT</small>
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
        <div class="row justify-content-center py-2">
            <div class="col-xl-4 col-lg-6">
                <form method="GET">
                    <div class="form-group text-center font-weight-bold">
                        <label>Filter by MONTH</label>
                        <div class="d-flex align-items-center">
                            <select class="form-control" name="month">
                                @foreach($months as $index => $month)
                                    <option value="{{ $index }}" {{ Request::get('month') == $index ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
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
                            <h3 class="col-12 mb-0">{{ __('Total in Activations') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableFuture" class="table align-items-center table-flush" style="width:100%"> 
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Plan</th>
                                        <th scope="col" class="text-center">Username</th>
                                        <th scope="col" class="text-center">Plan Value</th>
                                        <th scope="col" class="text-center">Generated at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activations as $activation)
                                    <tr>
                                        <th>
                                            {{ substr(sha1($activation->id), -4) }}
                                        </th>
                                        <th  class="text-center notranslate">
                                            {{ $activation->user()->username }}
                                        </th>
                                        <td class="text-center">
                                            {{ $activation->plan()->plan_value }} USDT
                                        </td>
                                        <td class="text-center">
                                            {{ $activation->created_at->format('Y-m-d') }}
                                        </td>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#tableFuture thead tr').clone(true).appendTo( '#tableFuture thead' );
            $('#tableFuture thead tr:eq(1) th:not(:eq(3))').each( function (i) {
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

            var table = $('#tableFuture').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                pagingType: "full_numbers",
                "order": [[ 3, "desc" ]],
                dom: 'lrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            } );
        });

    </script>
@endpush
