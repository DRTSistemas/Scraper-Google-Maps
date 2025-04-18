@extends('layouts.app', ['title' => 'Searchs', 'page' => 'searchs'])

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
    <div class="header pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Geral de Pesquisas</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $countRequests }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                            <i class="fa fa-check" aria-hidden="true"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Pesquisas nos últimos 30 dias</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $countLastRequests }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                            <i class="fa fa-check" aria-hidden="true"></i>
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
        <div class="d-none row justify-content-center py-2">
            <div class="col-xl-6 col-lg-6">
                <form method="GET">
                    <div class="form-group text-center font-weight-bold text-white">
                        <label>Filtre por data</label>
                        <div class="d-flex align-items-center">
                            <label class="mb-0 mx-2">De</label>
                            <input class="form-control" type="text" name="from" id="from" value="{{ $from }}">
                            <label class="mb-0 mx-2">Até</label>
                            <input class="form-control" type="text" name="to" id="to" value="{{ $to }}">
                            <button type="submit" class="btn btn-sm btn-success ml-2">
                                Filtrar
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
                            <h3 class="col-12 mb-0">Histórico de pesquisas dos últimos 30 dias</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableRequests" class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">Termo</th>
                                <th scope="col" class="text-center">Feito em</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr class="text-center">
                                        <td>{{ $request->term }}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($request->created_at)) }}</td>
                                        <td>
                                            <a href="{{ asset('storage/upload/' . $request->filename . '.xlsx') }}" download class="btn btn-sm btn-primary">
                                                Fazer Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        $('#tableRequests thead tr').clone(true).appendTo( '#tableRequests thead' );
        $('#tableRequests thead tr:eq(1) th:not( :eq(99) )').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            } );
        } );
        
        var table = $('#tableRequests').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pagingType: "full_numbers",
            "order": [[ $("#tableRequests").find('tr')[0].cells.length-1, "desc" ]],
            dom: 'lrtip',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
        } );
    </script>
@endpush