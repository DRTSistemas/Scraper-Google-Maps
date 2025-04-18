@extends('admin.layouts.app', ['title' => __('Configurações'), 'page' => 'config'])



@section('content')

    @include('users.partials.header', [

        'title' => '',

        'description' => '',

        'class' => 'col-lg-7'

    ])   



    <div class="container-fluid mt--7">

        <div class="row">

            <div class="col-xl-12 order-xl-1">

                <div class="card bg-secondary shadow">

                    <div class="card-header bg-white border-0">

                        <div class="row align-items-center">

                            <h3 class="col-12 mb-0">{{ __('Editar Variáveis ​​de Ambiente') }}</h3>

                        </div>

                    </div>

                    <div class="card-body">

                        <form method="post" action="{{ route('admin.config.update', 1) }}" autocomplete="off">

                            @csrf

                            @method('put')

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


                            <div class="form-group{{ $errors->has('api_key_serper') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-api_key_serper">{{ __('API Key Serper Dev') }}</label>

                                <div class="input-group">

                                    <input type="text" name="api_key_serper" id="input-api_key_serper" class="form-control form-control-alternative{{ $errors->has('api_key_serper') ? ' is-invalid' : '' }}" placeholder="{{ __('API Key Serper Dev') }}" value="{{ old('api_key_serper', $config['api_key_serper']) }}" required>

                                    @if ($errors->has('api_key_serper'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('api_key_serper') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('whatsapp_support') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-whatsapp_support">{{ __('Link WhatsApp de Suporte') }}</label>

                                <div class="input-group">

                                    <input type="text" name="whatsapp_support" id="input-whatsapp_support" class="form-control form-control-alternative{{ $errors->has('whatsapp_support') ? ' is-invalid' : '' }}" placeholder="{{ __('https://wa.me/55999999999') }}" value="{{ old('whatsapp_support', $config['whatsapp_support']) }}" required>

                                    @if ($errors->has('whatsapp_support'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('whatsapp_support') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>
                            

                            <div class="d-none form-group{{ $errors->has('max_profit') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-max_profit">{{ __('Lucro máximo por plano') }}</label>

                                <div class="input-group">

                                    <input type="text" name="max_profit" id="input-max_profit" class="form-control form-control-alternative{{ $errors->has('max_profit') ? ' is-invalid' : '' }}" placeholder="{{ __('Lucro máximo por plano') }}" value="{{ old('max_profit', $config['max_profit']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">%</div>

                                    </div>

                                    @if ($errors->has('max_profit'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('max_profit') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('max_donate') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-max_donate">{{ __('Porcentagem para doar') }}</label>

                                <div class="input-group">

                                    <input type="text" name="max_donate" id="input-max_donate" class="form-control form-control-alternative{{ $errors->has('max_donate') ? ' is-invalid' : '' }}" placeholder="{{ __('Porcentagem para doar') }}" value="{{ old('max_donate', $config['max_donate']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">%</div>

                                    </div>

                                    @if ($errors->has('max_donate'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('max_donate') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('max_receive') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-max_receive">{{ __('Porcentagem a receber') }}</label>

                                <div class="input-group">

                                    <input type="text" name="max_receive" id="input-max_receive" class="form-control form-control-alternative{{ $errors->has('max_receive') ? ' is-invalid' : '' }}" placeholder="{{ __('Porcentagem a receber') }}" value="{{ old('max_receive', $config['max_receive']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">%</div>

                                    </div>

                                    @if ($errors->has('max_receive'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('max_receive') }}</strong>

                                        </span>

                                    @endif                   

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('max_time_to_donate') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-max_time_to_donate">{{ __('Tempo máximo para doação') }}</label>

                                <div class="input-group">

                                    <input type="text" name="max_time_to_donate" id="input-max_time_to_donate" class="form-control form-control-alternative{{ $errors->has('max_time_to_donate') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo máximo para doação') }}" value="{{ old('max_time_to_donate', $config['max_time_to_donate']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">Minutos</div>

                                    </div>

                                    @if ($errors->has('max_time_to_donate'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('max_time_to_donate') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('min_payment_days') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-min_payment_days">{{ __('Dias mínimos para receber uma doação') }}</label>

                                <div class="input-group">

                                    <input type="text" name="min_payment_days" id="input-min_payment_days" class="form-control form-control-alternative{{ $errors->has('min_payment_days') ? ' is-invalid' : '' }}" placeholder="{{ __('Dias mínimos para receber uma doação') }}" value="{{ old('min_payment_days', $config['min_payment_days']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">Dias</div>

                                    </div> 

                                    @if ($errors->has('min_payment_days'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('min_payment_days') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('max_payment_days') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-max_payment_days">{{ __('Tempo máximo para receber uma doação') }}</label>

                                <div class="input-group">

                                    <input type="text" name="max_payment_days" id="input-max_payment_days" class="form-control form-control-alternative{{ $errors->has('max_payment_days') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempo máximo para receber uma doação') }}" value="{{ old('max_payment_days', $config['max_payment_days']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">Dias</div>

                                    </div>

                                    @if ($errors->has('max_payment_days'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('max_payment_days') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('max_dcommon_bonusonate') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-common_bonus">{{ __('Bônus para usuários comuns') }}</label>

                                <div class="input-group">

                                    <input type="text" name="common_bonus" id="input-common_bonus" class="form-control form-control-alternative{{ $errors->has('common_bonus') ? ' is-invalid' : '' }}" placeholder="{{ __('Bônus para usuários comuns') }}" value="{{ old('common_bonus', $config['common_bonus']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">%</div>

                                    </div>

                                    @if ($errors->has('common_bonus'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('common_bonus') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('master_bonus') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-master_bonus">{{ __('Bônus para usuários master') }}</label>

                                <div class="input-group">

                                    <input type="text" name="master_bonus" id="input-master_bonus" class="form-control form-control-alternative{{ $errors->has('master_bonus') ? ' is-invalid' : '' }}" placeholder="{{ __('Bônus para usuários master') }}" value="{{ old('master_bonus', $config['master_bonus']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">%</div>

                                    </div>

                                    @if ($errors->has('master_bonus'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('master_bonus') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('indications_to_master') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-indications_to_master">{{ __('Número de indicações para se tornar um usuário master') }}</label>

                                <div class="input-group">

                                    <input type="text" name="indications_to_master" id="input-indications_to_master" class="form-control form-control-alternative{{ $errors->has('indications_to_master') ? ' is-invalid' : '' }}" placeholder="{{ __('Número de indicações para se tornar um usuário master') }}" value="{{ old('indications_to_master', $config['indications_to_master']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">Indicações</div>

                                    </div>

                                    @if ($errors->has('indications_to_master'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('indications_to_master') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="d-none form-group{{ $errors->has('min_bonus_request') ? ' has-danger' : '' }}">

                                <label class="form-control-label" for="input-min_bonus_request">{{ __('Valor mínimo para solicitar bônus') }}</label>

                                <div class="input-group">

                                    <input type="text" name="min_bonus_request" id="input-min_bonus_request" class="form-control form-control-alternative{{ $errors->has('min_bonus_request') ? ' is-invalid' : '' }}" placeholder="{{ __('Valor mínimo para solicitar bônus') }}" value="{{ old('min_bonus_request', $config['min_bonus_request']) }}" required>

                                    <div class="input-group-prepend">

                                        <div class="input-group-text">USDT</div>

                                    </div>

                                    @if ($errors->has('min_bonus_request'))

                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $errors->first('min_bonus_request') }}</strong>

                                        </span>

                                    @endif

                                </div>

                            </div>

                            

                            <div class="text-center">

                                <button type="submit" class="btn btn-success mt-4">{{ __('Salvar') }}</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        

        @include('layouts.footers.auth')

    </div>

@endsection