@auth()
    @include('admin.layouts.navbars.navs.auth', ['page' => $page])
@endauth
    
@guest()
    @include('admin.layouts.navbars.navs.guest')
@endguest