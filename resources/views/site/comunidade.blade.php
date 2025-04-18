@extends('site.layouts.app')

    @push('custom-style')
        <link rel="stylesheet" href="/site/css/estilo-comunidade.css">
    @endpush

    @section('content')

    @include('site.partials.header') 

    <div class="titulo-comunidade m-3 m-lg-5 wow fadeInUp">
        <h1 class="text-center">Seed Community</h1>
    </div>

    <div class="container mb-5">
        <div class="row"> <!-- Inicio quem somos -->
            <div class="col-md-7" style="z-index: 3;">
                <div class="caixa1-comunidade">
                    <div class="interior-caixa1-comunidade wow fadeInUp">
                        <h1 class="text-center text-lg-left">WHO WE ARE</h1>
                        <p>
                            We are a large nonprofit self-help community, created by leaders
                             serious, who are committed to truth and transparency. Given the magnitude and
                             benefits offered, we receive members who join spontaneously and members
                             we become independent members of the community.
                        </p>
                        <p>We provide the best way to generate good fruits sowing prosperity.</p>
                        <p>We connect dreams to goals and achievements!</p>
                        <p>
                            Ethics and respect are principles that guide the way people think, act and work
                            Seed Community members. We are present on all continents, providing
                            new experiences and giving another meaning to the actions of planting and harvesting, through a
                            large donation structure to help our members thrive
                            financially.
                        </p>
                    </div>
                </div>
            </div>
        </div> <!-- Fim quem somos -->

        <div class="row justify-content-end" style="margin-top: calc(-100% / 4)">
            <div class="col-md-7" style="z-index: 2;">
                <img src="/site/img/pessoas-comunidade.png" class=" imagem d-block" style="margin-left: -65px; margin-top: 70px;">
            </div>
        </div>

        <div class="row objetivo" style="margin-top: calc(-100% / 18); margin-left: 45px;"> <!-- Inicio Objetivo -->
            <div class="col-md-7" style="z-index: 1;">
                <div class="caixa2-comunidade">
                    <div class="interior-caixa2-comunidade wow fadeInUp" style="margin-bottom: 120px;">
                        <h1>OBJECTIVE</h1>
                        <p>
                            Our mission is to raise the standard of living of the sowers that are part of the community.
                            We insert a new lifestyle, where practitioners achieve prosperity in a
                            fast, consistent and independent. Who plants, reaps!
                        </p>
                    </div>
                </div>
            </div>
        </div> <!-- FIm do objetivo -->

        <div class="row justify-content-end"> <!-- Inicio a comunidade -->
            <div class="col-md-8">
                <div class="caixa3-comunidade mt-5">
                    <div class="interior-caixa3-comunidade wow fadeInUp" style="margin-bottom: 120px;">
                        <h1>THE COMMUNITY</h1>
                        <p>​
                            We are a community, we depend on each other and together we practice actions that lead to
                            mutual success. To become a member it is necessary to accept the invitation of one of our
                            By accepting the terms and conditions of participation, you are placed in the position
                            donor, planting your seed in accordance with your free value option.
                            We advise you to start with minimum values ​​that do not compromise your daily budget. With
                            the results obtained, redo your donations by upgrading the plans and start the
                            climbing to reap the rewards and make your dreams come true. Your race, color, religion,
                            profession, financial condition or social position make no difference in the community, here
                            we are equal and the opportunities are the same for everyone. The difference in results goes
                            depend solely on the individual merit of each member.
                        </p>
                    </div>
                </div>
            </div>
        </div>    <!-- Fim da comunidade -->

        <div class="row" style="margin-top: calc(-100% / 8)">
            <div class="col-md-7" style="z-index: 1;">
                <img src="/site/img/planta-comunidade.png" class="w-100 d-block">
            </div>
        </div>

        <div class="row justify-content-end" style="margin-top: calc(-100% / 8);"> <!-- Inicio diferencial -->
            <div class="col-md-8" style="z-index: 2;">
                <div class="caixa4-comunidade mt-5">
                    <div class="interior-caixa4-comunidade wow fadeInUp">
                        <h1>DIFFERENTIAL</h1>
                        <p>
                            Following the evolution of the world and the emergence of new businesses, we have implemented a new
                            way to make spontaneous donations. We created an intelligent and independent system, using
                            Bitcoin as a universal currency within the community. Based on that, we adapted the way
                            fast-growing mutual aid to this global trend.
                        </p>
                    </div>
                </div>
            </div>
        </div> <!-- Fim diferencial -->
    </div>

    <div class="plantar py-5"><!-- Plantar & Colher -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center wow fadeInUp">
                    <h1>Plant & Harvest</h1>
                </div>
            </div>
        </div>
    </div> <!-- Fim plantar e colher -->

    <div class="plante-semente pt-3">  <!-- Duvidas -->
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-4 wow fadeInUp">
                    <p class="text-justify mb-3">
                        Following the mutual aid plan, you make the donation and automatically qualify to start receiving as well. Our members are not required to refer new members to start receiving!
                    </p>
                    <p style="background: #61F277; padding: 5px;">Plant the Seed and Make Your Donation.</p>
                    <p style="background: #61F277; padding: 5px;">Harvest the fruits.</p>
                    <p style="background: #61F277; padding: 5px;">Share Prosperity.</p>
                </div>
                <div class="col-md-4">
                    <img src="/site/img/planta.png" class="w-100 d-block"/>
                </div>
            </div>
        </div>
    </div> <!-- Fim duvidas --> <!-- CONTEUDO --> <!-- INICIO DO CONTEUDO -->

    @include('site.partials.footer')

    @endsection

