<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand p-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/logo.png" class="navbar-brand-img" width="150px" style="max-height: 100% !important;">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Bem Vindo!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Meu Perfil') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/green.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ ($page == 'dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-chart-line text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ ($page == 'search') ? 'active' : '' }}" href="{{ route('search') }}">
                        <i class="fas fa-search text-primary"></i> {{ __('Buscar Leads') }}
                    </a>
                </li>

                @if(empty(auth()->user()->google2fa_secret))
                <li class="nav-item">
                    <a type="button" class="nav-link {{ ($page == '2fa') ? 'active' : '' }}" data-toggle="modal" data-target="#Modal2FA">
                        <i class="fas fa-fingerprint text-primary"></i> {{ __('Habilitar 2FA') }}
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a type="button" class="nav-link {{ ($page == '2fa') ? 'active' : '' }}" data-toggle="modal" data-target="#ModalDisabled2FA">
                        <i class="fas fa-fingerprint text-primary"></i> {{ __('Desabilitar 2FA') }}
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link collapsed {{ ($page == 'reports') ? 'active' : '' }}" href="#navbar-reports" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-reports">
                        <i class="fa fa-chart-line text-primary"></i>
                        <span class="nav-link-text">{{ __('Relatórios') }}</span>
                    </a>

                    <div class="collapse {{ ($page == 'reports') ? 'show' : '' }}" id="navbar-reports" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('searchs') }}">
                                    Pesquisas Últimos 30 dias
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($page == 'profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fa fa-user text-primary"></i> {{ __('Perfil') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $config['whatsapp_support'] }}" target="_blank" >
                        <i class="fa fa-question text-primary"></i> {{ __('Suporte') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
