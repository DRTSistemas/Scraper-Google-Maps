@extends('layouts.app', ['title' => 'Reports', 'page' => 'reports'])

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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Aprovado</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            R$ {{ number_format((float)(''), 2, '.', '') }}
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Cancelado</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            R$ {{ number_format((float)(''), 2, '.', '') }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fa fa-times" aria-hidden="true"></i>
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
                                            R$ {{ number_format((float)(''), 2, '.', '') }} 
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
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row justify-content-center py-2 d-none">
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
                            <h3 class="col-12 mb-0">Minhas Vendas</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableSales" class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">Código</th>
                                <th scope="col" class="text-center">Valor</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Criado em</th>
                                <th scope="col" class="text-center">última atualizaçaõ em</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                <tr class="text-center">
                                    <td>{{ $sale->transaction_token }} 
                                        <button type="submit" class="btn btn-sm btn-primary ml-2" id="copy{{ $sale->id }}" onclick="copyLink(this.id, '{{ $sale->transaction_token }}')">
                                            Copiar
                                        </button>
                                    </td>
                                    <td>R$ {{ number_format((float)$sale->value, 2, '.', '') }}</td>
                                    <td>
                                        @if($sale->sale_status == 'paid')
                                            <span class="badge badge-success p-2">Aprovada</span>
                                        @else
                                            <span class="badge badge-danger p-2">Cancelada</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($sale->created_at)) }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($sale->updated_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $('#tableSales thead tr').clone(true).appendTo( '#tableSales thead' );
        $('#tableSales thead tr:eq(1) th:not( :eq(99) )').each( function (i) {
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
        
        var table = $('#tableSales').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pagingType: "full_numbers",
            "order": [[ $("#tableSales").find('tr')[0].cells.length-1, "desc" ]],
            dom: 'lrtip',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
        } );
    </script>
@endpush