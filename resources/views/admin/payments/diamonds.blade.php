@extends('admin.layouts.app', ['title' => __('Payment Diamonds'), 'page' => 'payment'])

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
                                <h5 class="card-title text-uppercase text-muted mb-0">Total in Activations<br><small>(last month)</small>
                                </h5>
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
                        <div class="row">
                            <div class="col text-center">
                                @if($users->count() > 0)
                                    <small>Each diamond will receive: </small>
                                    {{ number_format((float)(((2 / 100) *  $made) / $users->count()), 2, '.', '') }} USDT
                                @else
                                    <small>The total to be divided by the month's diamonds will be: </small>
                                    {{ number_format((float)(((2 / 100) *  $made) / 1), 2, '.', '') }} USDT
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <h5 class="card-title text-uppercase text-muted mb-0">Top Diamond <img src="{{ asset('img/diamond.png') }}" width="25px"></h5>
                                <span class="h2 font-weight-bold mb-0">
                                    {{ $topDiamond->username }}<br>
                                    <small>
                                        {{ number_format((float)$topDiamond->earnings_diamond, 2, '.', '') }} USDT
                                    </small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Payment Diamonds') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.diamonds.store') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Payment Diamonds') }}</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('total') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-total">{{ __('Total Made in Activations') }}</label>
                                    <input type="number" name="total" id="input-total" class="form-control form-control-alternative{{ $errors->has('total') ? ' is-invalid' : '' }}" placeholder="{{ __('Total Made in Activations') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if($users->count() > 0)
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Make Payment') }}</button>
                                    @else
                                    <button type="submit" class="btn btn-success mt-4" disabled>{{ __('Make Payment') }}</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />

                        <h6 class="heading-small text-muted mb-4">{{ __('Payment Avalaible to Diamonds') }}</h6>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <th>
                                            {{ $user->username }}
                                        </th>
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