@extends('layouts.app', ['class' => 'bg-default', 'page' => 'login'])



@section('content')

    @include('layouts.headers.guest')



    <div class="container mt--8 pb-5">

        <div class="row justify-content-center">

            <div class="col-lg-5 col-md-7">
                
                <div class="card bg-secondary shadow border-0">

                    <div class="card-body px-lg-5 py-lg-5">

                        <div class="text-center text-muted mb-4">

                            <small>

                                {{ __('Fazer Login') }}

                            </small>

                        </div>

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

                        <form role="form" method="POST" action="{{ route('login') }}">

                            @csrf



                            <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }} mb-3">

                                <div class="input-group input-group-alternative">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text"><i class="fa fa-user"></i></span>

                                    </div>

                                    <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuário') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>

                                </div>

                                @if ($errors->has('username'))

                                    <span class="invalid-feedback" style="display: block;" role="alert">

                                        <strong>{{ $errors->first('username') }}</strong>

                                    </span>

                                @endif

                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">

                                <div class="input-group input-group-alternative">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>

                                    </div>

                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Senha') }}" type="password" required>

                                </div>

                                @if ($errors->has('password'))

                                    <span class="invalid-feedback" style="display: block;" role="alert">

                                        <strong>{{ $errors->first('password') }}</strong>

                                    </span>

                                @endif

                            </div>

                            <div class="custom-control custom-control-alternative custom-checkbox">

                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>

                                <label class="custom-control-label" for="customCheckLogin">

                                    <span class="text-muted">{{ __('Lembrar de mim') }}</span>

                                </label>

                            </div>

                            <div class="text-center">

                                <button type="submit" class="btn btn-success my-4">{{ __('Fazer Login') }}</button>

                            </div>

                            <div class="text-center">

                                <span>É novo por aqui?</span>
                                <a href="{{ route('register') }}" class="h2 text-dark">

                                    <small>{{ __('Criar conta') }}</small>

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-6">

                        @if (Route::has('password.request'))

                            <a href="{{ route('password.request') }}" class="text-white">

                                <small>{{ __('Esqueceu sua senha?') }}</small>

                            </a>

                        @endif

                    </div>

                    

                </div>

            </div>

        </div>

    </div>

@endsection

