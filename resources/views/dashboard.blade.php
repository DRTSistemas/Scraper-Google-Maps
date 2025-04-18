@extends('layouts.app', ['page' => 'dashboard'])

@section('content')

<style>
    .modal { overflow: auto !important; }
</style>

<style>
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .pricing-box {
        background-color: #e8f0fe;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        flex-direction: column;
    }
    .pricing-title {
        font-size: 20px;
        font-weight: 900;
        line-height: 1.2;
        margin-bottom: 8px;
    }
    .pricing-subtitle {
        color: #d81b60;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 24px;
    }
    .price {
        font-size: 40px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 15px;
    }
    .vat {
        font-size: 24px;
        font-weight: 700;
        color: #555;
    }
    .price-details {
        margin: 5px 0;
        padding-left: 14px;
        list-style: square;
    }
    .price-details li {
        margin-bottom: 12px;
        font-size: 12px;
        line-height: 1.4;
    }
    .buy-button {
        display: block;
        background-color: #1a73e8;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 700;
        margin-top: auto;
        text-align: center;
    }
    .buy-button:hover {
        border: 1px solid #1a73e8;
        background-color: #FFF;
        color: #1a73e8;
    }
</style>

<div class="header pb-8 pt-5 pt-md-7">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row mb-3">
            <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pesquisas últimos 30 dias</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $countLastMonthRequests }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-hashtag"></i>
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pesquisas últimas 24 horas</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $countLastDayRequests }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-hashtag"></i>
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pesquisas restantes</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $requestsLeft }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-hashtag"></i>
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
    <div class="row justify-content-around mb-3">
        <div class="col-xl-6 text-center">
            <h2 class="text-center text-white">Novo por aqui? Veja o vídeo abaixo</h3>
            <iframe
            width="800"
            height="450"
            src="https://www.youtube.com/embed/h4sUDTnzEag?si=G1QOAGE2FIUFbVR6"
            title="YouTube video player"
            frameBorder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowFullScreen
            style="border: 5px solid #5e72e4"
            ></iframe>
        </div>
        <div class="d-none col-xl-3">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Recarregar</h3>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <select id="rechargeLinks" class="form-control">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" data-checkout="{{ $plan->link_checkout }}">
                                        Plano {{ $plan->name }} - R$ {{ number_format((float)($plan->plan_value), 2, '.', '') }} (R$ {{ number_format((float)($plan->search_value), 2, '.', '') }}/pesquisa)
                                    </option>
                                @endforeach
                            </select>

                            <p class="mt-2 mb-2"><small>* Todos os preços não incluem impostos. Impostos podem ser aplicados dependendo do seu país.</small></p>
                            <p class="mb-2"><small>** Os créditos são válidos por 6 meses.</small></p>

                            <a id="dynamicLinkCheckout" class="btn btn-primary" href="#" target="_blank">Comprar créditos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-5 mb-5">
            <div class="pricing-title text-center" style="font-size: 35px; margin-bottom: 25px;">Escolha o plano que melhor lhe atende</div>

            <div class="pricing-grid">
                @foreach($plans as $plan)
                    <div class="pricing-box">
                        <div class="pricing-title">{{ $plan->name }}</div>
                        <div class="pricing-subtitle">{{ round($plan->plan_value / $plan->search_value) }} pesquisas disponíveis</div>
                        <div class="price">R$ {{ number_format((float)($plan->plan_value), 2, '.', '') }}</div>
                        <ul class="price-details">
                            <li>R$ {{ number_format((float)($plan->search_value), 2, '.', '') }} por pesquisa*</li>
                            <li>Suporte Rápido via WhatsApp</li>
                            <li>Atualizações sem Custo Adicional</li>
                        </ul>
                        <small class="mb-2">* Cada pesquisa retorna até 199 contatos</small>
                        <a href="{{ $plan->link_checkout }}" target="_blank" class="buy-button">Comprar Créditos</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-none col-xl-12 mb-5">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Pagamentos</h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Plano</th>
                                <th scope="col" class="text-center">Enviar para</th>
                                <th scope="col" class="text-center">Valor</th>
                                <th scope="col" class="text-center">Status de Pagamento</th>
                                <th scope="col" class="text-right">Ação</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-none col-xl-7">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                      <!-- Card header -->
                      <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Total de ativações de referência direta <small>em USDT</small></h5>
                      </div>
                      <!-- Card body -->
                      <div class="card-body">
                        <div class="chart">
                          <!-- Chart wrapper -->
                          <canvas id="chart-bars" class="chart-canvas"></canvas>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

    @if(!empty(Session::get('error_code')))
    <script>
        $(function() {
            $('#Modal<?= Session::get('error_code'); ?>').modal('show');
        });
    </script>
    @endif

    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/js-cookie/js.cookie.js"></script>
    <script src="{{ asset('js') }}/dashboard.js"></script>
    <script>
        $('form').submit(function(){
            $(this).find(':input[type=submit]').prop('disabled', true);
        });
    </script>

    <script>
        function copyAddress(id) {
            var address = $('#'+id).text().trim();
            navigator.clipboard.writeText(address);

            $('i.fa-clipboard').tooltip('show');
            setTimeout(function(){ $('i.fa-clipboard').tooltip('hide'); }, 1000);
        }
    </script>

    <script>
        $(document).ready(function () {
            // Define o href inicial baseado no primeiro valor do select
            $("#dynamicLinkCheckout").attr("href", $("#rechargeLinks option:selected").data('checkout'));

            // Atualiza o href quando o select for alterado
            $("#rechargeLinks").on("change", function () {
                var newHref = $(this).find('option:selected').data('checkout');
                $("#dynamicLinkCheckout").attr("href", newHref);
            });
        });
    </script>

@endpush
