<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">



        <meta name="csrf-token" content="{{ csrf_token() }}">



        <title>{{ config('app.name') }}</title>

        <!-- Favicon -->

        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">

        <!-- Fonts -->

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Icons -->

        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">

        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- Argon CSS -->

        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

        <style>

            .funkyradio div {

            clear: both;

            overflow: hidden;

            }



            .funkyradio label {

            width: 100%;

            border-radius: 3px;

            border: 1px solid #D1D3D4;

            font-weight: normal;

            }



            .funkyradio input[type="radio"]:empty,

            .funkyradio input[type="checkbox"]:empty {

            display: none;

            }



            .funkyradio input[type="radio"]:empty ~ label,

            .funkyradio input[type="checkbox"]:empty ~ label {

            position: relative;

            line-height: 2.5em;

            text-indent: 3.25em;

            margin-top: 2em;

            cursor: pointer;

            -webkit-user-select: none;

                -moz-user-select: none;

                -ms-user-select: none;

                    user-select: none;

            }



            .funkyradio input[type="radio"]:empty ~ label:before,

            .funkyradio input[type="checkbox"]:empty ~ label:before {

            position: absolute;

            display: block;

            top: 0;

            bottom: -1px;

            left: 0;

            content: '';

            width: 2.5em;

            background: lightgray;

            border-radius: 3px 0 0 3px;

            }



            .funkyradio input[type="radio"]:hover:not(:checked) ~ label,

            .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {

                color: #888;

            }



            .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,

            .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {

                content: '\2714';

                text-indent: .1em;

                color: #fff;

            }



            .funkyradio input[type="radio"]:checked ~ label,

            .funkyradio input[type="checkbox"]:checked ~ label {

            color: #777;

            }



            .funkyradio input[type="radio"]:checked ~ label:before,

            .funkyradio input[type="checkbox"]:checked ~ label:before {

                content: '\2714';

                text-indent: .1em;

                color: #333;

                background-color: #ccc;

            }



            .funkyradio input[type="radio"]:focus ~ label:before,

            .funkyradio input[type="checkbox"]:focus ~ label:before {

            box-shadow: 0 0 0 3px #999;

            }



            .funkyradio-success input[type="radio"]:checked ~ label:before,

            .funkyradio-success input[type="checkbox"]:checked ~ label:before {

            color: #fff;

            background-color: #2dce89;

            }

        </style>

    </head>

    <body class="bg-default">

        @auth()

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                @csrf

            </form>

        @endauth

        

        <div class="main-content">



@include('layouts.headers.guest')



<!-- Top navbar -->

<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">

    <div class="container-fluid">

        <!-- Brand -->

        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('ASOL AÇÃO SOLIDÁRIA') }}</a>

        <!-- User -->

        <ul class="navbar-nav align-items-center d-none d-md-flex">

            <li class="nav-item dropdown">

                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="media align-items-center">

                        <span class="avatar avatar-sm rounded-circle">

                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg">

                        </span>

                        <div class="media-body ml-2 d-none d-lg-block">

                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>

                        </div>

                    </div>

                </a>

                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">

                    <div class=" dropdown-header noti-title">

                        <h6 class="text-overflow m-0">{{ __('Bem Vindo!') }}</h6>

                    </div>

                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();

                    document.getElementById('logout-form').submit();">

                        <i class="ni ni-user-run"></i>

                        <span>{{ __('Logout') }}</span>

                    </a>

                </div>

            </li>

        </ul>

    </div>

</nav>



<div class="container mt--8 pb-5">

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-12">

            <div class="card bg-secondary shadow border-0">

                <div class="card-body px-lg-5 py-lg-5">

                    <div class="text-center text-muted mb-4">

                        <h2>

                            {{ __('Planos') }}

                        </h2>

                        <!-- <small>Your account has no plan active</small><br> -->

                        <small>Escolha seu plano para começar a doar</small><br>

                        <small class="d-none">The first donation will be 100% of the choosen plan, the next ones will be {{$config['max_donate']}}%, and you will receive {{ $config['max_receive'] }}% each week until you reach {{$config['max_profit']}}% of the choosen value</small>

                    </div>

                    <form class="text-center" role="form" method="POST" action="{{ route('plan.store') }}">

                        @csrf



                        <div class="funkyradio">

                            <div class="funkyradio-success">

                                <input type="radio" name="plan" value="{{ $plan->id }}" id="{{ $plan->id }}" required/>

                                <label for="{{ $plan->id }}">{{ $plan->name }} | {{ $plan->plan_value }} USDT</label>

                            </div>

                        </div>

                        <br><br>

                        <div class="text-center">



                            

                        </div>

                        <div class="text-center">

                            <button type="submit" class="btn btn-success mt-4">{{ __('Selecionar Plano') }}</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>



</div>



@guest()

    @include('layouts.footers.guest')

@endguest

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

<script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>

    $('form').submit(function(){

        $(this).find(':input[type=submit]').prop('disabled', true);

    });

</script>

@stack('js')



<!-- Argon JS -->

<script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

</body>

</html>