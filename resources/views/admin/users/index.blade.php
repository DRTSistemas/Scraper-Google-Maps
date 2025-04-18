@extends('admin.layouts.app', ['title' => __('User'), 'page' => 'users'])

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <style>
        .dataTables_length,
        .dataTables_filter {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="header pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row justify-content-center mb-3">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total de Usuário (Ativos <small>&</small> Inat.)</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            {{ $users->count() }} 
                                            ({{ $totalUsersWithActivePlan }} 
                                                <small>&</small>
                                            {{ $totalUsersWithoutRequests }})
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Faturamento</h5>
                                        <span class="h2 font-weight-bold mb-0">
                                            R$ {{ number_format((float)($totalRevenue), 2, '.', '') }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Usuários</h3>
                            </div>

                            <div class="col text-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalCreate"><i class="fa fa-plus"></i> Adicionar Usuário</a>
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
                            <table id="tableUsers" class="table align-items-center table-flush display" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th  class="d-none" scope="col">ID</th>
                                        <th scope="col">Usuário</th>
                                        <th scope="col" class="text-center">Nome</th>
                                        <th scope="col" class="text-center">Com créditos?</th>
                                        <th scope="col" class="text-center">Pesquisas restantes</th>
                                        <th scope="col" class="text-right">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <th class="d-none">
                                                {{ $user->id }}
                                            </th>
                                            <th class="notranslate">
                                                {{ $user->username }}
                                            </th>
                                            <th class="text-center">
                                                {{ $user->name }}
                                            </th>
                                            <td class="text-center">
                                                @if($user->totalRequestsLeft() > 0)
                                                    <i class="fas fa-toggle-on text-primary"></i>
                                                    Sim
                                                @else
                                                    <i class="fas fa-toggle-off text-danger"></i>
                                                    Não
                                                @endif
                                            </td>
                                            <th class="text-center">
                                                {{ $user->totalRequestsLeft() }}
                                            </th>
                                            <td class="text-right">
                                                <a href="{{ route('impersonate', $user->id) }}" class="btn btn-default btn-sm">Acessar Usuário</a>
                                                @if($user->id != auth()->user()->id && $user->level != 1)
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#Modal{{ $user->id }}">Editar</button>
                                                @else
                                                    Admin
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($users as $user)

        <div class="modal fade" id="Modal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">

                    <div class="modal-body p-0">

                        <div class="card bg-secondary shadow border-0">

                            <div class="card-header">

                                <h4>Editar {{ $user->name }}</h4>

                            </div>

                            <div class="card-body px-lg-5 py-lg-5">

                                <form role="form" method="POST" action="{{ route('admin.user.update', $user->id) }}">

                                    @csrf

                                    @method('put')

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-name">{{ __('Nome') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome') }}" value="{{ old('name', $user->name) }}" required>

                                            @if ($errors->has('name'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('name') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-username">{{ __('Nome') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="username" id="input-username" class="form-control form-control-alternative{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuário') }}" value="{{ old('username', $user->username) }}" required>

                                            @if ($errors->has('username'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('username') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-email">{{ __('E-mail') }}</label>

                                        <div class="input-group">

                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('E-mail') }}" value="{{ old('email', $user->email) }}" required>

                                            @if ($errors->has('email'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('email') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-phone_number">{{ __('Telefone') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="phone_number" id="input-phone_number" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Telefone') }}" value="{{ old('phone_number', $user->phone_number) }}" required>

                                            @if ($errors->has('phone_number'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('phone_number') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-password">{{ __('Senha') }}</label>

                                        <div class="input-group">

                                            <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Senha') }}" value="{{ old('password') }}">

                                            @if ($errors->has('password'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('password') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('level') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-level">{{ __('Nível') }}</label>

                                        <small class="text-danger">1 para Admin e 0 para Usuário</small>
                                        <div class="input-group">
                                            <input type="number" name="level" id="input-level" class="form-control form-control-alternative{{ $errors->has('level') ? ' is-invalid' : '' }}" placeholder="{{ __('Nível') }}" value="{{ old('level', $user->level) }}" required>

                                            @if ($errors->has('level'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('level') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <hr>

                                    <h4>Créditos</h4>
                                    <small class="text-danger">Use números positivos para adicionar pesquisas e negativos para diminuir.</small><br>
                                    <small class="text-danger">Para adicionar pesquisas, insira somente um dos valores abaixo:</small><br>

                                    @foreach($plans as $plan)
                                        <small class="text-danger">Valor: <strong>{{ round($plan->plan_value / $plan->search_value) }}</strong></small><br>
                                    @endforeach

                                    <div class="form-group{{ $errors->has('requests_left') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-requests_left">{{ __('Pesquisas Disponíveis') }}: {{ $user->totalRequestsLeft() }}</label>

                                        <div class="input-group">
                                            <input type="number" name="requests_left" id="input-requests_left" class="form-control form-control-alternative{{ $errors->has('requests_left') ? ' is-invalid' : '' }}" placeholder="{{ __('Adicionar/Remover Pesquisas Disponíveis') }}" value="{{ old('requests_left') }}" required>

                                            @if ($errors->has('requests_left'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('requests_left') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-primary my-4">Salvar</button>

                                    </div>

                                </form>

                                <hr>

                                <form role="form" method="POST" action="{{ route('admin.user.destroy', $user->id) }}">

                                    @csrf

                                    @method('delete')

                                    <h4>Deletar Usuário</h4>

                                    <br>

                                    <div class="text-center">

                                        <button type="submit" class="btn btn-block btn-danger">Deletar Usuário</button>

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

                                <h4>Criar novo usuário</h4>

                            </div>

                            <div class="card-body px-lg-5 py-lg-5">

                                <form role="form" method="POST" action="{{ route('admin.user.store') }}">

                                    @csrf

                                    @method('post')

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-name">{{ __('Nome') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome') }}" value="{{ old('name') }}" required>

                                            @if ($errors->has('name'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('name') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-username">{{ __('Nome') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="username" id="input-username" class="form-control form-control-alternative{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Usuário') }}" value="{{ old('username') }}" required>

                                            @if ($errors->has('username'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('username') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-email">{{ __('E-mail') }}</label>

                                        <div class="input-group">

                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('E-mail') }}" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('email') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-phone_number">{{ __('Telefone') }}</label>

                                        <div class="input-group">

                                            <input type="text" name="phone_number" id="input-phone_number" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Telefone') }}" value="{{ old('phone_number') }}" required>

                                            @if ($errors->has('phone_number'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('phone_number') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-password">{{ __('Senha') }}</label>

                                        <div class="input-group">

                                            <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Senha') }}" value="{{ old('password') }}" required>

                                            @if ($errors->has('password'))

                                                <span class="invalid-feedback" role="alert">

                                                    <strong>{{ $errors->first('password') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group{{ $errors->has('level') ? ' has-danger' : '' }}">

                                        <label class="form-control-label" for="input-level">{{ __('Nível') }}</label>

                                        <select class="form-control" name="level" required>
                                            <option value="0">Usuário</option>
                                            <option value="1">Admin</option>
                                        </select>

                                        @if ($errors->has('level'))

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $errors->first('level') }}</strong>

                                            </span>

                                        @endif

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

@push('js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $('.input-search_value').mask('0.00000000', {reverse: false });
        $('.input-plan_value').mask('##0.00', {reverse: true });
    </script>

    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#tableUsers thead tr').clone(true).appendTo( '#tableUsers thead' );
            $('#tableUsers thead tr:eq(1) th:not(:eq(3), :eq(4), :eq(5))').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            $('#tableUsers thead tr:eq(1) th:eq(3)').each( function (i) {
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(this).empty() );

                select.append( '<option value="Sim">Sim</option>' );
                select.append( '<option value="Não">Não</option>' );

                $( 'select', this ).on( 'change', function () {
                    table.search(this.value).draw();
                } );


            } );

            var table = $('#tableUsers').DataTable( {
                orderCellsTop: true,
                fixedHeader: true,
                pagingType: "full_numbers",
                "order": [[ 0, "desc" ]],
                dom: 'lrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            } );
        });

    </script>

@endpush
