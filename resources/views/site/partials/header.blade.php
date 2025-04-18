<header>
    <nav class="navbar navbar-expand-md">
        <a href="/" class="d-flex align-items-center navbar-brand" style="margin-left: 30px;">
            <img src="/site/img/logo.png" width="150px">
        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#nav-principal">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav-principal">
            <ul class="menu-principal navbar-nav ml-auto text-center align-items-center">
                <li class="nav-item">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.community') }}">
                        The Community
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.donation') }}" >Donations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.plans') }}">Plans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="#contact">
                        Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-user-circle mr-2" style="font-size: 25px;"></i>
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header> <!-- Fim da barra -->