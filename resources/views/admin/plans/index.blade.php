@extends('admin.layouts.app', ['title' => __('Planos'), 'page' => 'plans'])



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

                    <div class="card-header border-0">

                        <div class="row align-items-center">

                            <div class="col">

                                <h3 class="mb-0">Planos</h3>

                            </div>

                            <div class="col text-right">

                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalCreate"><i class="fa fa-plus"></i> Adicionar Plano</a>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

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

                        <div class="table-responsive">

                            <!-- Projects table -->

                            <table class="table align-items-center table-flush">

                                <thead class="thead-light">

                                    <tr>

                                        <th scope="col">Nome do Plano</th>

                                        <th scope="col" class="text-center">Valor por Pesquisa</th>

                                        <th scope="col" class="text-center">Valor do Plano</th>

                                        <th scope="col" class="text-right">Ação</th>

                                        

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($plans as $plan)

                                    <tr>

                                        <th>

                                            {{ $plan->name }}

                                        </th>

                                        <th  class="text-center">
                                            {{ number_format((float)$plan->search_value, 2, '.', '') }}
                                        </th>

                                        <td class="text-center">
                                            {{ number_format((float)$plan->plan_value, 2, '.', '') }}
                                        </td>

                                        <td class="text-right">

                                            <button class="btn btn-info" data-toggle="modal" data-target="#Modal{{ $plan->id }}">Editar</button>

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                                {{ $plans->links() }}

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        @foreach($plans as $plan)

        <div class="modal fade" id="Modal{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body p-0">

                        <div class="card bg-secondary shadow border-0">

                            <div class="card-header">

                                <h4>Editar {{ $plan->name }}</h4>

                            </div>

                            <div class="card-body px-lg-5 py-lg-5">

                                <form role="form" method="POST" action="{{ route('admin.plan.update', $plan->id) }}">

                                    @csrf

                                    @method('put')

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-name">{{ __('Nome do Plano') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome do Plano') }}" value="{{ old('name', $plan->name) }}" required>

                                            @if ($errors->has('name'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('name') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('search_value') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-search_value">{{ __('Valor por Pesquisa') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="search_value" id="input-search_value" class="input-search_value form-control form-control-alternative{{ $errors->has('search_value') ? ' is-invalid' : '' }}" placeholder="{{ __('Valor para Ativação') }}" value="{{ old('search_value', $plan->search_value) }}" required>

                                            @if ($errors->has('search_value'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('search_value') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('plan_value') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-plan_value">{{ __('Valor do Plano') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="plan_value" id="input-plan_value" class="input-plan_value form-control form-control-alternative{{ $errors->has('plan_value') ? ' is-invalid' : '' }}" placeholder="{{ __('Valor do Plano') }}" value="{{ old('plan_value', $plan->plan_value) }}" required>
                                            
                                            @if ($errors->has('plan_value'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('plan_value') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('link_checkout') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-link_checkout">{{ __('Link Checkout') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="link_checkout" id="input-link_checkout" class="input-link_checkout form-control form-control-alternative{{ $errors->has('link_checkout') ? ' is-invalid' : '' }}" placeholder="{{ __('Link Checkout') }}" value="{{ old('link_checkout', $plan->link_checkout) }}" required>
                                            
                                            @if ($errors->has('link_checkout'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('link_checkout') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary my-4">Salvar</button>

                                    </div>

                                </form>

                                <hr>

                                <form role="form" method="POST" action="{{ route('admin.plan.destroy', $plan->id) }}">

                                    @csrf

                                    @method('delete')

                                    <h4>Deletar Plano</h4>

                                    <br>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-block btn-danger">Deletar Plano</button>

                                    </div>

                                    <small class="text-danger text-center">Cuidado, essa alteração não pode ser desfeita</small>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @endforeach





        <div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body p-0">

                        <div class="card bg-secondary shadow border-0">

                            <div class="card-header">

                                <h4>Criar novo plano</h4>

                            </div>

                            <div class="card-body px-lg-5 py-lg-5">

                                <form role="form" method="POST" action="{{ route('admin.plan.store') }}">

                                    @csrf

                                    @method('post')

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-name">{{ __('Nome do Plano') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome do Plano') }}" value="{{ old('name') }}" required>

                                            @if ($errors->has('name'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('name') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('search_value') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-search_value">{{ __('Valor para Ativação') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="search_value" id="input-search_value" class="input-search_value form-control form-control-alternative{{ $errors->has('search_value') ? ' is-invalid' : '' }}" placeholder="{{ __('Valor para Ativação') }}" value="{{ old('search_value') }}" required>

                                            <div class="input-group-prepend">

                                                <div class="input-group-text">USDT</div>

                                            </div>

                                            @if ($errors->has('search_value'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('search_value') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('plan_value') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-plan_value">{{ __('Valor do Plano') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="plan_value" id="input-plan_value" class="input-plan_value form-control form-control-alternative{{ $errors->has('plan_value') ? ' is-invalid' : '' }}" placeholder="{{ __('Valor do Plano') }}" value="{{ old('plan_value') }}" required>

                                            <div class="input-group-prepend">

                                                <div class="input-group-text">USDT</div>

                                            </div>

                                            @if ($errors->has('plan_value'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('plan_value') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary my-4">Salvar</button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        

        @include('layouts.footers.auth')

    </div>



    <script

        src="https://code.jquery.com/jquery-3.4.1.min.js"

        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="

        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>

    <script>

        //$('.input-search_value').mask('0.00000000', {reverse: false });

        //$('.input-plan_value').mask('##0.00', {reverse: true });

    </script>

@endsection