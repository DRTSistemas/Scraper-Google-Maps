@extends('admin.layouts.app', ['title' => __('Dashboard'), 'page' => 'dashboard'])

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
@include('users.partials.header', [
'title' => __('Bem vindo') ,
'description' => '',
'class' => 'col-lg-12'
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-5 order-xl-2 mb-5 my-5">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="col-12 mb-0">{{ __('Informações Gerais') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden;">
                        <table class="table align-items-center table-flush">
                            <tbody>
                                <tr>
                                    <th><a href="{{ route('admin.user.index') }}">Total de Usuários</a></th>
                                    <th><a href="{{ route('admin.user.index') }}"> {{ $users }} </a></th>
                                </tr>
                                <tr>
                                    <th>Faturamento</th>
                                    <th>R$ {{ number_format((float)($totalRevenue), 2, '.', '') }}</th>
                                </tr>
                                <tr>
                                    <th><a href="{{ route('admin.user.index') }}">Usuários com Créditos</a></th>
                                    <th><a href="{{ route('admin.user.index') }}"> {{ $totalUsersWithActivePlan }} </a></th>
                                </tr>
                                <tr>
                                    <th><a href="{{ route('admin.user.index') }}">Usuários sem Créditos</a></th>
                                    <th><a href="{{ route('admin.user.index') }}"> {{ $totalUsersWithoutRequests }} </a></th>
                                </tr>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    @if(!empty(Session::get('error_code')))
        <script>
            $(function() {
                console.log($('#Modal<?= Session::get('error_code'); ?>'));
                $('#Modal<?= Session::get('error_code'); ?>').modal('show');
            });
        </script>
    @endif

    <script>
        function copyAddress(id) {
            var address = $('#'+id).text().trim();
            navigator.clipboard.writeText(address);

            $('i.fa-clipboard').tooltip('show');
            setTimeout(function(){ $('i.fa-clipboard').tooltip('hide'); }, 1000);
        }

        // Setup - add a text input to each footer cell
        $('#tablePayments thead tr').clone(true).appendTo( '#tablePayments thead' );
        $('#tablePayments thead tr:eq(1) th:not( :eq(2),:eq(3),:eq(4),:eq(5),:eq(6),:eq(7) )').each( function (i) {
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

        var table = $('#tablePayments').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pagingType: "full_numbers",
            "order": [[ 5, "desc" ]],
            dom: 'lrtip',
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
        });
        console.log(table.page.info().recordsTotal);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.modal').on('show.bs.modal', function (e) {
            $.ajax({
                method: "POST",
                url: "/admin/removeTransaction",
                data: {
                    user: {!! json_encode(auth()->user()->id) !!},
                    transactionId: $(this).attr('id').replace('Modal', '')
                },
                success: (res) => {
                    if(!res.success) {
                        $('#Modal'+res.transaction).modal('hide');
                        $('#tablePayments a[data-target="#Modal'+res.transaction+'"]').closest('tr').remove();
                    }
                }
            });
        });

        $('.modal').on('hide.bs.modal', function (e) {
            $.ajax({
                method: "POST",
                url: "/admin/returnTransaction",
                data: {
                    user: {!! json_encode(auth()->user()->id) !!},
                    transactionId: $(this).attr('id').replace('Modal', '')
                },
                success: (res) => {
                    console.log(res);
                }
            });
        });
    </script>
    @endpush
