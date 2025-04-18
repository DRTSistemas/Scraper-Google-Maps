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

                                {{ __('Autenticação de dois fatores') }}

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

                        <form method="POST" action="{{ route('2fa.verify') }}">
                            @csrf
                            <p>{{ __('Insira sua senha de uso único para concluir seu login.') }}</p>
                            <div class="mb-4">
                                <div class="input-group custom" style="margin-bottom:0px;">
                                    <input type="password" name="one_time_password" class="form-control form-control-lg" placeholder="**********" />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                    </div>
                                </div>
                                @error('one_time_password')
                                    <div class="form-control-feedback text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="row mt-4 mb-4">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-danger btn-lg btn-block" type="submit" value="Verificar">
                                    </div>
                                    
                                </div>
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

