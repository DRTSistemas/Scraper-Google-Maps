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
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <!-- User -->
        </div>
    </nav>


    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="text-center text-muted mb-4">
                            <h2 class="panel-heading">Configurar o Google Authenticator</h2>
                            <h4>Baixe o aplicativo na Apple Store ou Play Store</h4>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <br>
                                    <a href="https://apps.apple.com/us/app/google-authenticator/id388497605"  target="_blank">
                                        <img alt='Get it on App Store' width="84%" src='https://linkmaker.itunes.apple.com/pt-br/badge-lrg.svg?releaseDate=2010-09-20&kind=iossoftware&bubble=ios_apps'/>
                                    </a>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2' target="_blank">
                                        <img alt='Get it on Google Play' width="99%" src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/>
                                    </a>
                                </div>
                            </div>
                            <h4>Configure sua autenticação de dois fatores escaneando o código de barras abaixo. Como alternativa, você pode usar o código {{ $secret }}</h4>
                            <div>
                                {!! $QR_Image !!}
                            </div>
                            <p class="text-danger">Você deve configurar seu aplicativo Google Authenticator antes de continuar. Você não conseguirá fazer login de outra forma</p>
                            <form class="form-horizontal" method="POST" action="{{ route('2fa.enable') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="verify-code" class="col-md-4 control-label">Código do autenticador</label>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <input id="verify-code" type="password" class="form-control" name="verify-code" required>
                                            @if ($errors->has('verify-code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('verify-code') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary">
                                                Habilitar 2FA
                                            </button>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-center align-items-center">
                                            <a class="h4 mb-0 text-uppercase" href="{{ route('home') }}">Voltar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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

@stack('js')

<!-- Argon JS -->
<script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>
</html>
