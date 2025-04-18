<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <!-- Author -->
    <meta name="author" content="Seed Community">
    <!-- Page Title -->
    <title>Seed Community | Prosperity as a Lifestyle</title>
    <!-- Favicon -->
    <link href="" rel="icon">
    <!-- Bundle -->
    <link href="{{ asset('site') }}/vendor/css/bundle.min.css" rel="stylesheet">
    <!-- Plugin Css -->
    <link href="{{ asset('site') }}/seedcommunity/css/line-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/revolution-settings.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/cubeportfolio.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/LineIcons.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/seedcommunity/css/slick.css" rel="stylesheet">
    <link href="{{ asset('site') }}/seedcommunity/css/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('site') }}/vendor/css/wow.css" rel="stylesheet">
    <!-- Style Sheet -->
    <link href="{{ asset('site') }}/seedcommunity/css/blog.css" rel="stylesheet">
    <link href="{{ asset('site') }}/seedcommunity/css/style.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="90">

<!--Header Start-->
<header id="home" class="cursor-light">

    <div class="inner-header nav-icon header-appear">
        <div class="main-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-4 col-lg-3">
                        <a class="navbar-brand link" href="/">
                            <img src="{{ asset('site') }}/seedcommunity/img/logo.png" class="logo-simple" alt="logo">
                            <img src="{{ asset('site') }}/seedcommunity/img/logo-white-small.png" class="logo-fixed" alt="logo">
                        </a>
                    </div>
                    <div class="col-8 col-lg-9 simple-navbar d-flex align-items-center justify-content-end">
                        <nav class="navbar navbar-expand-lg">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <div class="navbar-nav ml-auto">
                                    <a class="nav-link home active link" href="/">HOME</a>
                                    <a class="nav-link scroll link" href="#contact-sec">CONTACT</a>
                                    <a class="nav-link scroll link" onclick="openLogin()" style="cursor: pointer;">LOGIN</a>
                                    <span class="menu-line"><i aria-hidden="true" class="fa fa-angle-down"></i></span>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--toggle btn-->
        <a href="javascript:void(0)" class="sidemenu_btn link d-block d-lg-none" id="sidemenu_toggle">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>
    <!--Side Nav-->
    <div class="side-menu hidden side-menu-opacity">
        <div class="bg-overlay"></div>
        <div class="inner-wrapper">
            <span class="btn-close" id="btn_sideNavClose"><i></i><i></i></span>
            <div class="container">
                <div class="row w-100 side-menu-inner-content">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <a href="index-seedcommunity.html" class="navbar-brand"><img src="{{ asset('site') }}/seedcommunity/img/logo-white.png" alt="logo"></a>
                </div>
                <div class="col-12 col-lg-8">
                    <nav class="side-nav w-100">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link scroll" href="/">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#contact-sec">CONTACT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" onclick="openLogin()" style="cursor: pointer;">LOGIN</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            </div>
        </div>
    </div>
    <a id="close_side_menu" href="javascript:void(0);"></a>

</header>
<!--Header End-->

<section class="video-about mt-5 pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-8 stats-heading-area text-center mt-5 pb-2">
                @if(Request::get('country'))
                    @switch(Request::get('country'))
                        @case('us')
                            <h4 class="heading mb-0">OUR GOAL</h4>
                            <h5 class="heading" style="font-size: 20px; font-weight: 300;">
                                PROSPEROUS SEEDS
                            </h5>
                            <p class="text">
                                Our mission is to raise the standard of living of the sowers that are part of the community. We insert a new lifestyle, where practitioners achieve prosperity in a fast, consistent and independent. Who plants, reaps!
                            </p> 
                            @break
                        @case('br')
                            <h4 class="heading mb-0">NOSSO OBJETIVO</h4>
                            <h5 class="heading" style="font-size: 20px; font-weight: 300;">
                                SEMENTES PRÓSPERAS
                            </h5>
                            <p class="text">
                                Nossa missão é elevar o padrão de vida dos semeadores que fazem parte da comunidade. Inserimos um novo estilo de vida, onde os praticantes alcançam a prosperidade de forma rápida, consistente e independente. Quem planta, colhe!
                            </p> 
                            @break
                        @case('es')
                            <h4 class="heading mb-0">NUESTRO OBJETIVO</h4>
                            <h5 class="heading" style="font-size: 20px; font-weight: 300;">
                                SEMILLAS PRÓSPERAS
                            </h5>
                            <p class="text">
                                Nuestra misión es elevar el nivel de vida de los sembradores que forman parte de la comunidad. Insertamos un nuevo estilo de vida, donde los practicantes logran la prosperidad de una manera rápida, consistente e independiente. ¡Quien planta, cosecha!
                            </p> 
                            @break
                        @default
                            <h4 class="heading mb-0">OUR GOAL</h4>
                            <h5 class="heading" style="font-size: 20px; font-weight: 300;">
                                PROSPEROUS SEEDS
                            </h5>
                            <p class="text">
                                Our mission is to raise the standard of living of the sowers that are part of the community. We insert a new lifestyle, where practitioners achieve prosperity in a fast, consistent and independent. Who plants, reaps!
                            </p> 
                    @endswitch
                @else
                    <h4 class="heading mb-0">OUR GOAL</h4>
                    <h5 class="heading" style="font-size: 20px; font-weight: 300;">
                        PROSPEROUS SEEDS
                    </h5>
                    <p class="text">
                        Our mission is to raise the standard of living of the sowers that are part of the community. We insert a new lifestyle, where practitioners achieve prosperity in a fast, consistent and independent. Who plants, reaps!
                    </p>  
                @endif
                
                @if(Request::get('country'))
                    @switch(Request::get('country'))
                        @case('us')
                            <iframe src="https://player.vimeo.com/video/528657554?byline=0&portrait=0&title=0&controls=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @break
                        @case('br')
                            <iframe src="https://player.vimeo.com/video/528658729?byline=0&portrait=0&title=0&controls=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @break
                        @case('es')
                            <iframe src="https://player.vimeo.com/video/529318957?byline=0&portrait=0&title=0&controls=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @break
                        @default
                            <iframe src="https://player.vimeo.com/video/528657554?byline=0&portrait=0&title=0&controls=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    @endswitch
                @else
                    <img src="{{ asset('site') }}/seedcommunity/img/video.jpg" class="w-100">    
                @endif

                <button type="button" class="btn btn-success btn-sm mt-3" data-toggle="modal" data-target="#switchLanguage">
                  Switch Language
                </button>

                <a type="button" href="/" class="btn btn-default btn-sm mt-3">
                  Back to home
                </a>
            </div>
        </div>
    </div>
</section>

<div class="modal" id="switchLanguage" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content text-center text-white" style="background: transparent; border: none;">
        <div class="modal-body">
          <h4>To see in English</h4>
          <a href="?country=us">
            <img src="https://www.countryflags.io/us/shiny/64.png">
          </a>
          <h4>Para ver en español</h4>
          <a href="?country=es">
          <img src="https://www.countryflags.io/es/shiny/64.png">
          </a>
          <h4>Para ver em Português</h4>
          <a href="?country=br">
          <img src="https://www.countryflags.io/br/shiny/64.png">
          </a>
        </div>
      </div>
    </div>
</div>

<!--Contact section start-->
<section class="contact-sec pt-5 pb-5" id="contact-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 wow fadeInLeft">
                <h4 class="heading text-center text-lg-left">GET IN TOUCH</h4>
                @if(Session::has('success'))
                  <div class="alert alert-success">
                    {{ Session::get('success') }}
                   </div>
                @endif
                <form method="post" action="{{ route('contact') }}" class="row contact-form" id="contact-form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12" id="result"></div>
                    <div class="col-12 col-md-5">
                        <input type="text" placeholder="Your Name" required="" name="userName"  class="form-control">
                        <input type="email" placeholder="Email Address *" required="" name="userEmail" class="form-control">
                        <input type="text" placeholder="Subject" required="" name="userSubject" class="form-control">
                    </div>
                    <div class="col-12 col-md-7">
                        <textarea class="form-control" placeholder="Your Message" name="userMessage" rows="6"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn contact_btn white-btn rounded-pill w-100">Send Message
                            <span></span><span></span><span></span><span></span><span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--Contact section end-->

<!--Footer Start-->
<footer class="footer-style-1 pb-2">

    <div class="container">
        <div class="row align-items-center">
            <!--Text-->
            <div class="col-lg-12 text-center">
                <p class="company-about fadeIn">Copyrights © 2021 Seed Community All rights reserved
                </p>
            </div>
        </div>
    </div>
</footer>
<!--Footer End-->

<!--Animated Cursor-->
<div class="aimated-cursor">
    <div class="cursor">
        <div class="cursor-loader"></div>
    </div>
</div>
<!--Animated Cursor End-->

<!--Scroll Top Start-->
<span class="scroll-top-arrow"><i class="fas fa-angle-up"></i></span>
<!--Scroll Top End-->

<!-- JavaScript -->
<script type="text/javascript">
    function openLogin() {
        window.open({!! json_encode(url('/login')) !!}, '_self');
    }
</script>
<script src="{{ asset('site') }}/vendor/js/bundle.min.js"></script>
<!-- Plugin Js -->
<script src="{{ asset('site') }}/vendor/js/jquery.appear.js"></script>
<script src="{{ asset('site') }}/vendor/js/jquery.fancybox.min.js"></script>
<script src="{{ asset('site') }}/vendor/js/owl.carousel.min.js"></script>
<script src="{{ asset('site') }}/vendor/js/parallaxie.min.js"></script>
<script src="{{ asset('site') }}/vendor/js/wow.min.js"></script>
<script src="{{ asset('site') }}/vendor/js/jquery.cubeportfolio.min.js"></script>

<!--Tilt Js-->
<script src="{{ asset('site') }}/vendor/js/TweenMax.min.js"></script>
<!-- custom script-->
<script src="{{ asset('site') }}/seedcommunity/js/circle-progress.min.js"></script>

<script src="{{ asset('site') }}/seedcommunity/js/script.js"></script>

<script type="text/javascript">
    $(function() {
        let searchParams = new URLSearchParams(window.location.search);
        (!searchParams.has('country')) ? $('.modal').modal('show') : '';
    });
</script>

</body>
</html>