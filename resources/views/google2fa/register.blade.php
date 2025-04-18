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
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('plan.index') }}">{{ __('Seed Community') }}</a>
            <!-- User -->
        </div>
    </nav>


    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                        <h2 class="panel-heading">Set up Google Authenticator</h2>
                        <h4>Download the app on Apple Store or Play Store</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                            <br>
                                <a href="https://apps.apple.com/us/app/google-authenticator/id388497605?mt=8"  target="_blank">
                                    <img alt='Get it on App Store' width="84%" src='https://linkmaker.itunes.apple.com/pt-br/badge-lrg.svg?releaseDate=2010-09-20&kind=iossoftware&bubble=ios_apps'/>
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=pt_BR&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1' target="_blank">
                                    <img alt='Get it on Google Play' width="99%" src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/>
                                </a>
                            </div>
                        </div>
                        <h4>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</h4>
                            <div>
                                <img src="{{ $QR_Image }}">
                            </div>
                            <p class="text-danger">You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                            <div>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Complete Registration</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to confirmation -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm 2FA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Verify step by step</h4>
                <p>- Download Google Authenticator (IOs and Android)</p>
                <p>- Scan QR Code From this page</p>
                <p>- Check in your app your email, and auth code</p>
                <p>- Click "Complete Registration"</p>
                Are you sure you want to continue?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                <a href="/complete-registration" class="btn btn-primary">Complete Registration</a>
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