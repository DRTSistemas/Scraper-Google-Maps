@extends('site.layouts.app')

    @push('custom-style')
        <link rel="stylesheet" href="/site/css/estilo-doacao.css">
    @endpush

    @section('content')

    @include('site.partials.header')

    <div class="titulo-doacao m-3 m-lg-5 wow fadeInUp">
        <h1 class="text-center">PROSPERITY</h1>
    </div>

    <div class="container">
        <div class="row"> <!-- Mudar vida -->
            <div class="col-md-7">
                <div class="caixa1-doacao">
                    <div class="interior-caixa1-doacao wow fadeInUp">
                        <h1>How the Seed Community Can Change Your Life</h1>
                        <p>The inclusion system is safe, simple and automated. To participate, you must receive an invitation from an active member. After accepting the terms and conditions of the community system, follow the next steps.</p>
                        <p><b>Plant the Seed by Making Your Donation!</b></p>
                        <p>Choose a value within the conditions that does not compromise your daily needs. After the donation is made, you will become an active member, thus having all the rights and benefits offered by the community.</p>
                        <p><b>Harvest the fruits!</b></p>
                        <p>Following the mutual aid plan, you make the donation and automatically qualify to start receiving as well. Our members are not required to refer new members to start receiving!</p>
                        <p><b>Share Prosperity!</b></p>
                        <p>Presenting this opportunity is another way to benefit from the community.</p>
                        <p>With seriousness, ethics and common sense, show the world what we are. Do not offer an advantage or benefit that is not expressly disclosed on the official community website.</p>
                        <p>Through two programs: <b> Direct and indirect referral </b>, we offer bonuses directly to your BLOCKCHAIN account. The more people who join through your disclosure, the more Bitcoin you get.</p>
                    </div>
                </div>
            </div>
        </div> <!-- Fim mudar vida -->
    </div>

    <section class="caixa-fotos pt-4">
        <div class="container">
            <div class="row no-gutters justify-content-center ">
                <div class="col-md-4">
                    <img src="/site/img/imagem1-doacao.png" class="img-fluid w-100">
                </div>
                <div class="col-md-4">
                    <img src="/site/img/imagem2-doacao.png" class="img-fluid w-100">
                </div>
                <div class="col-md-4">
                    <img src="/site/img/imagem3-doacao.png" class="img-fluid w-100">
                </div>
            </div>
        </div> <!--Inicio Seção -->
    </section> <!-- Fim da seção -->

    <div class="container">
        <div class="row"> <!-- Mudar vida -->
            <div class="col-md-7 offset-sm-5">
                <div class="caixa2-doacao mt-4">
                    <div class="interior-caixa2-doacao wow fadeInUp">

                        <div class="titulo-caixa2">
                            <h1>7 REASONS</h1>
                        </div>


                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>The opportunity to build your own online business;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Possibilities for receiving unlimited donations;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Be part of the largest mutual aid community in the world;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Upgrade donation plans at any time;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Live the future! Work with cryptocurrencies, the new world trend;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Do good! Contribute to the fulfillment of other people's dreams;</p>

                        <p><i class="far fa-thumbs-up fa-2x ml-4 mr-3"></i>Become a leader and be recognized in national and international territory.</p>

                    </div>
                </div>
            </div>
        </div> <!-- Fim mudar vida -->
    </div>

    <div class="border"></div>

    <div class="container">
        <div class="row"> <!-- Mudar vida -->
            <div class="col-md-7" style="z-index:2;">
                <div class="caixa3-doacao">
                    <div class="interior-caixa3-doacao wow fadeInUp">
                        <h1>HOW ARE THE DONATIONS</h1>
                        <p>Every member of the community needs to donate part of the amount received directly to other members, thus streamlining the entire processing of the system in a transparent manner in its operation and ensuring security for the sustainability of the community.</p>
                        <p>The community will mobilize jointly among members to provide each participant with their weekly income. This ensures that everyone has a return of at least twice the capital invested initially donated in each plan.</p>
                        <p>The system is fully digital and automatic. Members exchange spontaneous donations, in a direct payment process, without the intermediation of third parties. In this way, the money spins within the community creating a sustainable credibility, based on the individual commitment of each member who received their donations and need to redo the donation of part of what they received in order to continue receiving.</p>
                    </div>
                </div>
            </div>
        </div> <!-- Fim mudar vida -->
    </div>

    <section class="d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-sm-5 wow fadeInUp" style="z-index:1;">
                    <img src="/site/img/seed-money.png" class="seed-money img-fluid w-100">
                </div>
            </div>
        </div> <!--Inicio Seção -->
    </section> <!-- Fim da seção -->

    <div class="borda1"></div>

    <div class="tecnologia">
        <div class="row">
            <div class="col-sm-10 offset-sm-1 wow fadeInUp">
                <h1>Seed Blockchain TECHNOLOGY</h1>
                <p>Through an automated and independent system, WE CREATE a new lifestyle for people. With the success of Bitcoin, several technologies have emerged to facilitate and introduce its application and use in people's daily lives. This is how BLOCKCHAIN emerges, a kind of decentralized database, which enables cryptocurrency transactions to be carried out through a global networked system. Each member of the community must have or create an account with a Wallet ID at BLOCKCHAIN.COM and register their wallet in the receiving area of our community. Blockchain technology is a /site, distributed ledger that records all virtual currency transactions in a block chain, where anyone can participate and check the authenticity of payments</p>
            </div>
        </div>
    </div>
    @include('site.partials.footer')

    @endsection
