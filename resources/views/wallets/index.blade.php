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

        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('wallet.index') }}">{{ __('ASOL AÇÃO SOLIDÁRIA') }}</a>

        <!-- User -->

        <ul class="navbar-nav align-items-center d-flex">

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
                    @impersonating
                        <a href="{{ route('impersonate.leave') }}" class="dropdown-item">
                            <i class="fa fa-undo"></i>
                            Voltar para o ADMIN
                        </a>
                    @endImpersonating
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

            <div class="col-lg-5 col-md-7">

                <div class="card bg-secondary shadow border-0">

                    <div class="card-body px-lg-3 py-lg-5">

                        <div class="text-center text-muted mb-4">

                            <h2>Cadastre sua carteira USDT</h2>

                            <small>

                                {{ __('Insira seu endereço para receber as doações') }}

                            </small>

                        </div>

            
                        @if($is_update)
                            <form role="form" method="POST" action="{{ route('wallet.update') }}">
                                @csrf
                                @method('put')
                        @else
                            <form role="form" method="POST" action="{{ route('wallet.store') }}">
                                @csrf
                        @endif

                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} mb-3">

                                <div class="input-group input-group-alternative">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>

                                    </div>

                                    <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="bnbxxxxxxx...xxxxxxxxx" type="address" name="address" value="{{ old('address') }}" value="" required autofocus>

                                </div>

                                @if (session('error'))

                                    <span class="invalid-feedback" style="display: block;" role="alert">

                                        <strong>{{ session('error') }}</strong>

                                    </span>

                                @endif

                            </div>

                            <div class="text-center">

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalWallet">
                                  Continuar
                                </button>

                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalWallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">⚠️ SOBRE SUA TRUST WALLET</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body py-1">
                                    <p>
                                    Tenha a segurança de ter informado um endereço de carteira válido onde você tem acesso. Mantenha sua chave privada (frases de recuperação) registrada em um lugar seguro onde somente você tenha acesso. ESTEJA CIENTE DE QUE SE VOCÊ INSERIR UM ENDEREÇO ​​DE RECEBIMENTO NO REGISTRO E POR QUALQUER MOTIVO VOCÊ PERDER O ACESSO À SUA CARTEIRA e não tiver a frase de recuperação em mãos, você perderá todos os seus fundos, e é de sua inteira responsabilidade manter a segurança de sua frase de recuperação.
                                    </p>
                                    <p>
                                        Alterar sua carteira USDT BEP2 ou qualquer um dos dados mencionados acima requer processos de segurança por meio de suporte, processos que levarão tempo para serem concluídos.
                                    </p>
                                    <p>
                                        Então, registre corretamente e guarde esses dados em um lugar seguro, em um bloco de notas, ou anote-os em um papel e guarde-os em um lugar seguro que você lembre onde estão.
                                    </p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-success">{{ __('Registrar Carteira') }}</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                        </form>

                        <div class="text-center text-muted mb-4">

                            <small>

                                {{ __('Baixe o aplicativo Trust Wallet para obter um endereço USDT') }}

                            </small>

                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-4">
                                <a href="https://apps.apple.com/app/apple-store/id1288339409?pt=1324988&amp;ct=website&amp;mt=8">
                                </a>
                                <img src="{{ asset('img/ios.jpg') }}" width="135px">
                            </div>
                            <div class="col-12 col-lg-4">
                                <a href="https://play.google.com/store/apps/details?id=com.wallet.crypto.trustapp&amp;referrer=utm_source%3Dwebsite">
                                <img src="{{ asset('img/android.jpg') }}">
                                </a>
                            </div>
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