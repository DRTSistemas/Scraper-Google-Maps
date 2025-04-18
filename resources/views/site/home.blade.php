<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <!-- Author -->
    <meta name="author" content="Seed Community">
    
    <meta name="facebook-domain-verification" content="6bq7fu5pr8w9ko3f8d6kaql30u187a" />
    
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

<!-- Preloader -->
<div class="preloader">
    <div class="center">
        <div class="spinner">
            <div class="blob top"></div>
            <div class="blob bottom"></div>
            <div class="blob left"></div>
            <div class="blob move-blob"></div>
        </div>
    </div>
</div>
<!-- Preloader End -->

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
                                    <a class="nav-link home active link" href="#">HOME</a>
                                    <a class="nav-link scroll link" href="#about-sec">ABOUT US</a>
                                    <a class="nav-link scroll link" href="#works-sec">HOW IT WORKS</a>
                                    <a class="nav-link scroll link" href="#starter-sec">GET STARTED</a>
                                    <a class="nav-link scroll link" href="#plans-sec">PLANS</a>
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
                                <a class="nav-link scroll" href="#home">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#about-sec">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#works-sec">HOW IT WORKS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#starter-sec">GET STARTED</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link scroll" href="#plans-sec">PLANS</a>
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

<!--Banner start-->
<section class="banner-slider padding-bottom position-relative cursor-light" id="banner-slider">
    <div class="container">
        <div class="row banner-slider-row">
            <div class="col-12 col-lg-12 d-flex align-items-center justify-content-center text-center">
                <div class="slider-banner-content wow slideInLeft" data-wow-delay=".8s">
                    <h4 class="heading">PROSPERITY <span>As a Lifestyle</span></h4>
                    <a href="#about-sec" class="btn green-btn rounded-pill text-white nav-link scroll link">Who we are
                    <span></span><span></span><span></span><span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Banner End-->

<!--Stats sec start-->
<section class="stats-sec pt-5 pb-5" id="about-sec">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 stats-heading-area text-center">
                <h4 class="heading mb-0">Let's prosper together!</h4>
                <h5 class="heading" style="font-size: 25px; font-weight: 300;">Be a member of our community</h5>
                <p class="text">
                    We are a large non-profit self-help community, created by serious leaders who are committed to truth and transparency. Given the magnitude and benefits offered, we welcome members who spontaneously join and make us stronger.
                </p>
                <p class="text">
                    We provide the best way to generate good fruits sowing prosperity.
                </p>
                <p class="text">
                    We connect dreams to goals and achievements!
                </p>
                <p class="text">
                    Ethics and respect are principles that guide the way people think, act, and work within the community. We are an international community that through the internet we are present in all continents, providing new experiences and giving another meaning to the actions of planting and harvesting through a large donation structure to help our members prosper financially.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="video-about pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-6 stats-heading-area text-center pb-2">
                <a href="{{ route('site.presentation') }}">
                    <img src="{{ asset('site') }}/seedcommunity/img/video.jpg" class="w-100">
                    <style type="text/css">
                        .pulse {
                          animation: pulse 0.7s infinite;
                          margin: 0 auto;
                          display: table;
                          margin-top: 50px;
                          animation-direction: alternate;
                          -webkit-animation-name: pulse;
                          animation-name: pulse;
                        }

                        @-webkit-keyframes pulse {
                          0% {
                            -webkit-transform: scale(1);
                            -webkit-filter: brightness(100%);
                          }
                          100% {
                            -webkit-transform: scale(1.1);
                            -webkit-filter: brightness(200%);
                          }
                        }

                        @keyframes pulse {
                          0% {
                            transform: scale(1);
                            filter: brightness(100%);
                          }
                          100% {
                            transform: scale(1.1);
                            filter: brightness(200%);
                          }
                        }
                    </style>
                
                    <img src="{{ asset('site') }}/seedcommunity/img/play-button.svg" width="60px" style="position: absolute; bottom: 30px; left: calc(100% / 2.2)" class="pulse">
                </a>
            </div>
            <div class="col-12 col-lg-6 stats-heading-area text-center">
                <h4 class="heading mb-0">OUR GOAL</h4>
                <h5 class="heading" style="font-size: 20px; font-weight: 300;">Prosperous Seeds</h5>
                <p class="text">
                    Our mission is to raise the standard of living of the sowers that are part of the community. We insert a new lifestyle, where practitioners achieve prosperity in a fast, consistent and independent. Who plants, reaps!
                </p>
            </div>
        </div>
    </div>
</section>

<section class="video-about pt-5 pb-5" id="works-sec" style="background-color: #FFF;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 stats-heading-area text-center">
                <h4 class="heading mb-0">HOW IT WORKS</h4>
                <h5 class="heading" style="font-size: 20px; font-weight: 300;">TRANSPARENCY AND HONESTY</h5>
                <p class="text">
                    The community was designed to work fairly and automatically. Donations made within the&nbsp;<span class="notranslate">Seed Community</span>&nbsp;are directed in an orderly and automatic manner to other members/plans who have previously donated and are awaiting a receipt. The calendar is designed to generate donations within an average period of seven (7), days after your full donation is paid.
                </p>
                <p class="text">
                    The community was created to manage donations in a fair and transparent way, allowing users who make donations to other members through our system to insert the hash that can be verified at any time by the donor and the recipient. The system has been programmed to generate donations to the active member in the percentage of 40% (forty percent) of the amount initially donated. To continue receiving your donation, the system asks this user to make a new donation equivalent to 30% (thirty percent) of the initial amount of your plan. This process should be repeated, leaving 10% (ten percent) for the member during 16 receipts, after the 16th receipt he should receive a last donation of 40% (forty percent), ending his plan with a total of 200% (two hundred percent) based on the amount initially donated in each plan.
                </p>
                <h5 class="heading" style="font-size: 20px; font-weight: 300; text-transform: none; color: #584d4d; -webkit-text-fill-color: unset;">All donations are made using <a href="https://coinmarketcap.com/alexandria/article/what-are-cryptocurrencies" target="_blank" style="color: #1baacc;">cryptocurrencies</a>. The currency used by the community today is <a href="https://academy.binance.com/en/articles/what-is-tether-usdt" target="_blank" style="color: #1baacc;">USDT (Tether USDT)</a></h5>
            </div>
        </div>
    </div>
</section>

<section class="video-about pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 stats-heading-area text-center">
                <h4 class="heading mb-0">A SAFE COMMUNITY</h4>
                <h5 class="heading" style="font-size: 20px; font-weight: 300; margin: 30px 0 5px 0;">AMONG OUR MEMBERS</h5>
                <p class="text">
                    Every member of the community needs to donate part of the amount received directly to other members, thus streamlining the entire processing of the system in a transparent manner in its operation and ensuring security for the sustainability of the community.
                </p>
                <p class="text">
                    The community will mobilize jointly among members to provide each participant with their weekly income. This ensures that everyone has an income of at least double the capital initially donated in each plan.
                </p>
                <p class="text">
                    The system is fully digital and automatic. Members exchange spontaneous donations, in a direct payment process, without the intermediation of third parties. In this way, the money spins within the community creating a sustainable credibility, based on the individual commitment of each member who received their donations and need to redo the donation of part of what they received in order to continue receiving.
                </p>
                <h5 class="heading" style="font-size: 20px; font-weight: 300; margin: 30px 0 5px 0;">IN TRANSACTIONS</h5>
                <p class="text">
                    Through an automated and independent system, we create the possibility for our members to enjoy a new lifestyle. With the success of cryptocurrencies, various technologies have emerged to facilitate and introduce their application and use in people's daily lives.
                </p>
                <p class="text">
                    This is how Seed Chain emerges, a decentralized database that allows cryptocurrency transactions to be carried out through a global network system.
                </p>
                <p class="text">
                    Each member of the community must have or create a USDTBEP2 wallet in the Trust Wallet application and register it in the receiving area of our community.
                </p>
                <p class="text">
                    Seed Chain/Blockchain technology is a distributed ledger/website that records all virtual currency transactions in a block chain, where anyone can participate and verify the authenticity of payments.
                </p>
                <p class="text">
                    Unlike a traditional bank, instead of the information being stored on a central computer, on the blockchain it is stored on thousands of computers around the world. Each computer on the network keeps a complete copy of the database, which makes the information entered in it extremely safe and reliable, as there is no single point of attack. That is, the central computer cannot be hacked to access the transaction records and modify them. Each computer in this network has a record of this information, when trying to change a computer's database, it will be expelled by the rest of the network. The technology is perfect for those companies and people who need to record information in a reliable, secure and transparent way.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="video-about pt-5 pb-5" style="background-color: #FFF;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 stats-heading-area text-center pb-2">
                <img src="{{ asset('site') }}/seedcommunity/img/bg-4.jpg">
            </div>
            <div class="col-12 col-lg-6 stats-heading-area text-center">
                <h4 class="heading mb-0" style="font-size: 32px;">7 reasons to choose <br> Seed Community</h4>
                <h5 class="heading" style="font-size: 20px; font-weight: 300; margin-bottom: 15px;"></h5>
                
                <ul class="text-left">
                    <li>The opportunity to build your own online business</li>
                    <li>Possibilities for receiving unlimited donations</li>
                    <li>Be part of the largest mutual aid community in the world</li>
                    <li>Upgrade donation plans at any time</li>
                    <li>Live the future! Work with cryptocurrencies, the new world trend</li>
                    <li>Do good! Contribute to the fulfillment of other people's dreams</li>
                    <li>Become a leader and be recognized in national and international territory</li>
                </ul>

                <p> </p>

            </div>
        </div>
    </div>
</section>
<!--Stats sec End-->

<!--Portfolio section start-->
<section class="getting-start pt-5 pb-5" id="starter-sec">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 stats-heading-area text-center">
                <h4 class="heading mb-0">PROSPERITY STARTS HERE</h4>
                <h5 class="heading" style="font-size: 25px; font-weight: 300;">A QUICK GUIDE TO GET STARTED</h5>
            </div>
        </div>
        <div class="row justify-content-center">
            <ul class="process-wrapp mb-5">
                <li class="whitecolor wow fadeIn" data-wow-delay="300ms">
                    <span class="pro-step mb-2">01</span>
                    <h5 class="heading mb-3" style="font-size: 15px;">
                        REGISTER WITH THE COMMUNITY AND CHOOSE A PLAN
                    </h5>
                </li>
                <li class="whitecolor wow fadeIn" data-wow-delay="400ms">
                    <span class="pro-step mb-2">02</span>
                    <h5 class="heading mb-3" style="font-size: 15px;">
                        CREATE AN ACCOUNT AT BINANCE.COM AND BUY USDT AND BNB
                    </h5>
                    <a href="https://binance.com" target="_blank" class="btn white-btn rounded-pill">
                        BINANCE.COM
                        <span></span><span></span><span></span><span></span>
                    </a>
                </li>
                <li class="whitecolor wow fadeIn" data-wow-delay="500ms">
                    <span class="pro-step mb-2">03</span>
                    <h5 class="heading" style="font-size: 15px; margin-bottom: 33px;">
                        DOWNLOAD THE TRUST WALLET APP AND SELECT YOUR USDTBEP2 WALLET
                    </h5>
                    <a href="https://trustwallet.com" target="_blank" class="btn white-btn rounded-pill">
                        APP DOWNLOAD
                        <span></span><span></span><span></span><span></span>
                    </a>
                </li>
                <li class="whitecolor wow fadeIn" data-wow-delay="600ms">
                    <span class="pro-step mb-2">04</span>
                    <h5 class="heading" style="font-size: 15px;">
                        PUT YOUR APP USDTBEP2 RECEIPT WALLET IN THE COMMUNITY
                    </h5>
                </li>
                <li class="whitecolor wow fadeIn" data-wow-delay="700ms">
                    <span class="pro-step mb-2">05</span>
                    <h5 class="heading" style="font-size: 15px;">
                        MAKE YOUR FIRST DONATION
                    </h5>
                </li>
            </ul>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 stats-heading-area text-center">
                <h5 class="heading" style="font-size: 25px; font-weight: 300;">
                    DID YOU UNDERSTAND ANY STEP? WE HELP YOU
                </h5>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12 col-lg-12">
                <a href="#contact-sec" class="nav-link scroll link btn white-btn rounded-pill">
                    CONTACT US
                    <span></span><span></span><span></span><span></span>
                </a>
            </div>
        </div>
    </div>
</section>
<!--Portfolio section end-->

<!--Pricing section start-->
<section class="pricing-sec pt-5 pb-5" id="plans-sec">
    <div class="container">
        <div class="row">
            <div class="col-12 pricing-heading-area text-center">
                <h4 class="heading">CHOOSE YOUR <span class="color">PLAN</span></h4>
            </div>
        </div>
        <div class="row pricing-cards justify-content-center">
            <div class="col-12 col-md-6 col-lg-2 pricing-card">
                <div class="pricing-box wow fadeInUp">
                    <div class="pricing-box-header position-relative">
                        <div class="pricing-header-overlay"></div>
                        <div class="header-content text-center">
                            <h4 class="pricing-price">40</h4>
                            <small>USDT</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 pricing-card">
                <div class="pricing-box wow fadeInUp">
                    <div class="pricing-box-header position-relative">
                        <div class="pricing-header-overlay"></div>
                        <div class="header-content text-center">
                            <h4 class="pricing-price">50</h4>
                            <small>USDT</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 pricing-card active">
                <div class="pricing-box wow fadeInUp">
                    <div class="pricing-box-header position-relative">
                        <div class="pricing-header-overlay"></div>
                        <div class="header-content text-center">
                            <h4 class="pricing-price">100</h4>
                            <small>USDT</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 pricing-card">
                <div class="pricing-box wow fadeInUp">
                    <div class="pricing-box-header position-relative">
                        <div class="pricing-header-overlay"></div>
                        <div class="header-content text-center">
                            <h4 class="pricing-price">500</h4>
                            <small>USDT</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 pricing-card">
                <div class="pricing-box wow fadeInUp">
                    <div class="pricing-box-header position-relative">
                        <div class="pricing-header-overlay"></div>
                        <div class="header-content text-center">
                            <h4 class="pricing-price">1000</h4>
                            <small>USDT</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Pricing section end-->

<section class="video-about pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 stats-heading-area text-center">
                <h5 class="heading" style="font-size: 20px; font-weight: 300; margin-bottom: 0;">IT DOES NOT STOP THERE</h5>
                <h4 class="heading mb-5">Referral Program</h4>
            </div>    
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <ul class="text-left" style="list-style: none;">
                    <li class="custom-progress">
                        <h6 class="font-18 mb-0 text-capitalize">1st Level <span class="float-right"><b class="font-secondary font-weight-500 numscroller">5</b>% commission</span></h6>

                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </li>
                    <li class="custom-progress">
                        <h6 class="font-18 mb-0 text-capitalize">2st Level<span class="float-right"><b class="font-secondary font-weight-500 numscroller">1</b>% commission</span></h6>

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </li>
                    <li class="custom-progress">
                        <h6 class="font-18 mb-0 text-capitalize">3st Level<span class="float-right"><b class="font-secondary font-weight-500 numscroller">1</b>% commission</span></h6>

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </li>
                    <li class="custom-progress mb-0">
                        <h6 class="font-18 mb-0 text-capitalize">4st Level <span class="float-right"><b class="font-secondary font-weight-500 numscroller">1</b>% commission</span></h6>

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-12 text-center py-4">
                <img src="{{ asset('site') }}/seedcommunity/img/more.png" width="50px">
            </div>
            <div class="col-lg-5 stats-heading-area text-center">
                <div class="row pb-3">
                    <div class="col-lg-12">
                        <h4 class="heading mb-0" style="font-size: 25px;">Master Leader</h4>
                        <img src="{{ asset('site') }}/seedcommunity/img/icon-1.png" width="85px">
                    </div>
                    <div class="col-lg-12">
                        <p class="text">
                            To become a MASTER member and qualify for the bonus, it will be necessary to make a total of 5.000 USDT in donations/adhesions of new direct referral members within the month, that is, it will not be cumulative. The Master bonus will be 5% on all new membership plans for new direct referral registrations within the month.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 d-flex justify-content-center align-items-center">
                <div class="row pb-3">
                    <div class="col-lg-12">
                        <img src="{{ asset('site') }}/seedcommunity/img/more.png" width="30px">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 stats-heading-area text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="heading mb-0" style="font-size: 25px;">Diamond Leader</h4>
                        <img src="{{ asset('site') }}/seedcommunity/img/icon-2.png" width="85px">
                    </div>
                    <div class="col-lg-12">
                        <p class="text">
                            To qualify as a diamond, you need to qualify for the MASTER bonus for 3 consecutive months (a total of 5,000 USDT in donations / new memberships in the month). All DIAMONDS qualified for the previous month's master bonus will participate in an apportionment of 2% of the total new registration revenue in the month.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

</body>
</html>