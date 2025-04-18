@extends((auth()->user()->level == 1) ? 'admin.layouts.app': 'layouts.app', ['title' => __('Reports'), 'page' => 'reports'])

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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Plans</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $totalPlans }}
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Plans Value</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float) $plansValues, 2, '.', '') }} <small>USDT</small>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Grand Total</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ number_format((float)$total, 2, '.', '') }} <small>USDT</small>
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
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Donations in Line') }}</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableInline" class="table align-items-center table-flush" style="width:100%">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">From</th>
                                <th scope="col" class="text-center">Plan</th>
                                <th scope="col" class="text-center">To</th>
                                <th scope="col" class="text-center">Plan</th>
                                <th scope="col" class="text-center">Donation Value</th>
                                <th scope="col" class="text-center">Hash</th>
                                <th scope="col" class="text-center">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td class="text-center notranslate">
                                        @if(!empty($donation->userPlan()))
                                            {{ $donation->userPlan()->user()->username }}
                                        @endif        
                                    </td>
                                    <th class="text-center">
                                        @if(!empty($donation->userPlan()->plan()))
                                            {{ substr(sha1($donation->userPlan()->id), -4) }}
                                        @else
                                            {{ substr(sha1(rand(1, 21)), -4) }}
                                        @endif
                                    </th>
                                    <td class="text-center notranslate">
                                        @if(!empty($donation->user()))
                                            {{ $donation->user()->username }}
                                        @endif
                                    </td>
                                    <th class="text-center">
                                        @if(!empty($donation->donation()->userPlan()))
                                            {{ substr(sha1($donation->donation()->userPlan()->id), -4) }}
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        {{ $donation->value }} USDT
                                    </td>
                                    <td class="text-center">
                                            @if(!empty($donation->hash))
                                                <button type="submit" class="btn btn-sm btn-primary" id="copy{{ $donation->id }}" onclick="copyLink(this.id, '{{ $donation->hash }}')">
                                                    Copy Hash
                                                </button>
                                            @endif
                                        </td>
                                    <td class="text-center">
                                        {{ $donation->updated_at->format('j F, Y') }}
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $('.input-search_value').mask('0.00000000', {reverse: false });
        $('.input-plan_value').mask('##0.00', {reverse: true });
    </script>

    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#tableInline thead tr').clone(true).appendTo( '#tableInline thead' );
            $('#tableInline thead tr:eq(1) th:not(:eq(5), :eq(6))').each( function (i) {
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

            var table = $('#tableInline').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                pagingType: "full_numbers",
                "order": [[ 0, "desc" ]],
                dom: 'lrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            } );
        });

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
