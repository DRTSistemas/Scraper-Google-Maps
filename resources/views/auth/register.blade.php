@extends('layouts.app', ['class' => 'bg-default', 'page' => 'register'])

@push('styles')
<style>
    #TermsModal span {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')

@include('layouts.headers.guest')

<div class="container mt--8 pb-5">

    <!-- Table -->

    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-8">

            <div class="card bg-secondary shadow border-0">

                <div class="card-body px-lg-5 py-lg-5">

                    <div class="text-center text-muted mb-4">

                        <small>{{ __('Registar') }}</small>

                    </div>

                    <form id="formRegister" role="form" method="POST" action="{{ route('register') }}">

                        @csrf


                        <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative mb-3">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="ni ni-circle-08"></i></span>

                                </div>

                                <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuário') }}" type="text" name="username" value="{{ old('username') }}" required autofocus>

                            </div>

                            @if ($errors->has('username'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('username') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative mb-3">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="ni ni-single-02"></i></span>

                                </div>

                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome') }}" type="text" name="name" value="{{ old('name') }}" required>

                            </div>

                            @if ($errors->has('name'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('name') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('country_code') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative mb-3">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="fa fa-flag"></i></span>

                                </div>

                                <!-- <input class="form-control{{ $errors->has('country_code') ? ' is-invalid' : '' }}" placeholder="{{ __('country_code') }}" type="text" name="country_code" value="{{ old('country_code') }}" required> -->

                                <select class="form-control"  name="country_code" id="country_code">

                                    @foreach($countries as $country)

                                    <option value="{{ $country->phonecode }}">{{ $country->nicename }} ({{ $country->phonecode }})</option>

                                    @endforeach

                                </select>

                            </div>

                            @if ($errors->has('country_code'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('country_code') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative mb-3">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>

                                </div>

                                <input class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Whatsapp') }}" type="text" name="phone_number" value="{{ old('phone_number') }}" required>

                            </div>

                            @if ($errors->has('phone_number'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('phone_number') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative mb-3">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>

                                </div>

                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required>

                            </div>

                            @if ($errors->has('email'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('email') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">

                            <div class="input-group input-group-alternative">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>

                                </div>

                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Senha') }}" type="password" name="password" required>

                            </div>

                            @if ($errors->has('password'))

                            <span class="invalid-feedback" style="display: block;" role="alert">

                                <strong>{{ $errors->first('password') }}</strong>

                            </span>

                            @endif

                        </div>

                        <div class="form-group">

                            <div class="input-group input-group-alternative">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>

                                </div>

                                <input class="form-control" placeholder="{{ __('Confirmar Senha') }}" type="password" name="password_confirmation" required>

                            </div>

                        </div>

                            <!-- <div class="text-muted font-italic">

                                <small>{{ __('password strength') }}: <span class="text-success font-weight-700">{{ __('strong') }}strong</span></small>

                            </div> -->

                            <div class="text-center">

                                <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#TermsModal">{{ __('Criar conta') }}</button>

                            </div>

                            <div class="modal fade" id="TermsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-body pb-0">
            
        </div>
        <div class="modal-footer pt-0" style="align-items: baseline; justify-content: center;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Discordo</button>
            <button type="submit" class="btn btn-success mt-4">Aceito</button>
        </div>
    </div>
</div>
</div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('js')
<script type="text/javascript">
    $(function() {
        
    });
</script>
@endpush