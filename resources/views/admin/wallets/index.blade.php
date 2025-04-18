@extends('admin.layouts.app', ['title' => __('Carteiras'), 'page' => 'wallets'])

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
                                <h3 class="mb-0">Carteiras</h3>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalCreate"><i class="fa fa-plus"></i> Adicionar Carteira</a>
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
                                        <th scope="col">Carteira USDT</th>
                                        <th class="text-center">Informações</th>
                                        <th scope="col" class="text-right">Ações</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wallets as $wallet)
                                    <tr>
                                        <th>
                                            {{ $wallet->address }}
                                        </th>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-succes" target="_blank">Informações da Carteira</a>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#Modal{{ $wallet->id }}">Deletar</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{ $wallets->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($wallets as $wallet)
        <div class="modal fade" id="Modal{{ $wallet->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-header">
                                <h4>Deletar Carteira</h4>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5">
                                <form role="form" method="POST" action="{{ route('admin.wallet.destroy', $wallet->id) }}">
                                    @csrf
                                    @method('delete')
                                    <h4>Tem certeza de que deseja excluir esta carteira?</h4>
                                    <h5>{{$wallet->address}}</h5>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block btn-danger">Excluir carteira</button>
                                    </div>
                                    <small class="text-danger text-center">Be careful, this change cannot be undone</small>
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
                                <h4>Criar uma nova carteira</h4>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5">
                                <form role="form" method="POST" action="{{ route('admin.wallet.store') }}">
                                    @csrf
                                    @method('post')
                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-address">{{ __('Carteira USDT') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="address" id="input-address" class="input-address form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Bitcoin Address') }}" value="{{ old('address') }}" required>
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
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


@endsection