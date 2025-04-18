@extends((auth()->user()->level == 1) ? 'admin.layouts.app': 'layouts.app', ['title' => __('Reports'), 'page' => 'reports'])

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
                            <h3 class="col-12 mb-0">{{ __('Donations Users') }}</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table id="tableUsers" class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">From</th>
                                <th scope="col" class="text-center">Plan</th>
                                <th scope="col" class="text-center">To</th>
                                <th scope="col" class="text-center">Plan</th>
                                <th scope="col" class="text-center">Donation Value</th>
                                <th scope="col" class="text-center">Donate Status</th>
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
                                    <th class="text-center notranslate">
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
                                    <th class="text-center notranslate">
                                        @if(!empty($donation->donation()->userPlan()))
                                            {{ substr(sha1($donation->donation()->userPlan()->id), -4) }}
                                        @else    
                                            Bonus payment
                                        @endif
                                    </th>
                                    <td class="text-center">
                                        {{ $donation->value }} USDT
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($donation->hash) && $donation->status == 0)
                                            Waiting Confirmation
                                        @elseif($donation->status == 1)
                                            Confirmed
                                        @elseif($donation->status == 2)
                                            Expired
                                        @else
                                            Waiting Payment
                                        @endif
                                    </td>
                                    <td class="text-center">
                                            @if(!empty($donation->hash))
                                                <button type="submit" class="btn btn-sm btn-primary" id="copy{{ $donation->id }}" onclick="copyLink(this.id, '{{ $donation->hash }}')">
                                                    Copy Hash
                                                </button>
                                            @endif
                                        </td>
                                    <td class="text-center">
                                        {{ $donation->updated_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $donations->links() }}
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
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
