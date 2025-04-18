@auth()
    @include('layouts.navbars.navs.auth', ['page' => $page])
@endauth
    
@guest()
    @include('layouts.navbars.navs.guest')
@endguest