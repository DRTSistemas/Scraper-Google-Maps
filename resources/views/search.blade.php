@extends('layouts.app', ['page' => 'search'])

@section('content')

<style>
    .modal { overflow: auto !important; }
</style>

<div class="header pb-8 pt-5 pt-md-7">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row mb-3 justify-content-end">
                <div class="col-xl-12 col-lg-12 text-right">
                    <a class="btn btn-sm btn-primary" href="/home">Comprar créditos</a>
                </div>
            </div>
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
    <div class="row">
        <div class="col-xl-12">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-white">Busca</label>
                        <div class="form-group">
                            <div class="input-group mb-4">
                              <input class="form-control" type="text" id="input-buscar" name="input-buscar" placeholder="O que deseja buscar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label>País</label>
                        <div class="form-group selectWrapper">
                            <input class="form-control" type="text" id="pais" name="pais" value="Brasil">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Estado</label>
                        <div class="form-group selectWrapper">
                            <input class="form-control" type="text" id="estado" name="estado" placeholder="Digite um Estado">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Cidade</label>
                        <div class="form-group selectWrapper">
                            <input class="form-control" type="text" id="cidade" name="cidade" placeholder="Digite uma Cidade">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Bairro</label>
                        <div class="form-group selectWrapper">
                            <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Digite um Bairro">
                        </div>
                    </div>
                </div>

                @if(auth()->user()->hasActivePlan())
                    <div class="row align-items-center pb-3 extractionProgress">
                        <div class="col-md-12">
                            <h5 class="text-danger">
                                DURANTE O PROCESSO DE EXTRAÇÃO MANTENHA ESSA PÁGINA ABERTA ATÉ QUE SEJA CONCLUÍDO!
                            </h5>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="only_mobile" name="only_mobile" checked>
                                <label class="custom-control-label font-weight-bold" for="only_mobile">Filtrar apenas leads com telefones CELULARES</label>
                            </div>
                        </div>

                        <div class="col-md-12 align-items-center text-center my-4">
                            <button type="button" class="btn btn-success mr-4" id="runExtract">Buscar Leads</button>
                            <button type="button" class="btn btn-danger " id="stopExtract" disabled>Parar</button>
                        </div>
                        <div class="col-md-6 loading" style="display: none; margin: 0 auto;">
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 12px;">
                                    Aguarde, realizando a busca...
                                </span>
                                <span style="font-size: 12px;">
                                    Leads Encontrados: <span id="findPhones">0</span>
                                </span>
                            </div>
                            <div class="progress mt-1 mb-0">
                              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center text-center pb-5 extractionWithDataBase" style="display: none">
                        <div class="col-md-12">
                            <h4 class="text-success mb-0">
                                A EXTRAÇÃO FOI CONCLUÍDA. CLIQUE NO BOTÃO ABAIXO PARA FAZER DOWNLOAD DO ARQUIVO EM FORMATO .XLSX (EXCEL)
                            </h4>
                            <h5>Leads Encontrados: <span id="findPhonesInDataBase">0</span></h5>
                        </div>

                        <div class="col-md-12">
                            <input type="button" class="btn btn-success" id="btnExportData" value="Exportar para XLSX" onclick="doit('xlsx');">
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <a href="/search" type="button" class="btn btn-default">REALIZAR NOVA CONSULTA</a>
                        </div>

                        <div class="col-md-12 mt-3">
                            <a href="#" target="_blank">
                                Caso não tenha encontrado nenhum resultado para sua pesquisa, clique aqui pra entrar em contato com nosso suporte.
                            </a>
                        </div>
                    </div>
                @else
                    <div class="row mt-3">
                        <div class="col-xl-12 col-lg-12 text-center">
                            <h3>Você precisa adquirir mais créditos de pesquisas.</h3>
                            <a class="btn btn-primary" href="/home">Comprar créditos</a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="false">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <table class="table table-responsive" id="tableExtract">
          <thead>
            <tr>
                <th scope="col">Consulta</th>
                <th scope="col">Nome</th>
                <th scope="col">Endereço Completo</th>
                <th scope="col">Logradouro</th>
                <th scope="col">Número</th>
                <th scope="col">Complemento</th>
                <th scope="col">Bairro</th>
                <th scope="col">Cidade</th>
                <th scope="col">Estado</th>
                <th scope="col">CEP</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Categoria</th>
                <th scope="col">Nota</th>
                <th scope="col">Avaliações</th>
                <th scope="col">Telefone</th>
                <th scope="col">Site</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
            const dadosSalvos = localStorage.getItem('SpyLeads_UltimaPesquisa');
            if (dadosSalvos) {
                const dados = JSON.parse(dadosSalvos);

                $('#pais').val(dados.country !== "N/A" ? dados.country : '');
                $('#estado').val(dados.state !== "N/A" ? dados.state : '');
                $('#cidade').val(dados.city !== "N/A" ? dados.city : '');
                $('#bairro').val(dados.neighborhood !== "N/A" ? dados.neighborhood : '');
                $('#input-buscar').val(dados.search !== "N/A" ? dados.search : '');
                $('#only_mobile').prop('checked', dados.onlyMobile === "Mobile");
            }
        });
    </script>

    <script>
        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
            return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
            return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.text += ' (matched)';

            // You can return modified objects from here
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(document).ready(function() {
            $('select').select2({
                placeholder: 'Selecione umas das opções'
            });
        });
    </script>

    <script>
        function doit(type, dl) {

            // Capturando os valores dos inputs e garantindo um formato padronizado
            var data = {
                country: $('#pais').val() || "N/A",
                state: $('#estado').val() || "N/A",
                city: $('#cidade').val() || "N/A",
                neighborhood: $('#bairro').val() || "N/A",
                search: $('#input-buscar').val() || "N/A",
                onlyMobile: $('#only_mobile').is(":checked") ? "Mobile" : "Todos"
            };

            // Gerando um nome amigável para um arquivo Excel (sem espaços e caracteres especiais)
            var fileName = `Relatorio_${data.country}_${data.state}_${data.city}_${data.neighborhood}_${data.search}_${data.onlyMobile}`
                .replace(/[\s\/\\:*?"<>|]/g, '') // Remove caracteres inválidos para nome de arquivo

            var elt = document.getElementById('tableExtract');
            var wb = XLSX.utils.table_to_book(elt, {sheet:"Planilha"});

            var ws = wb.Sheets["Planilha"]; //  get the current sheet

            let countRows = $('table.table > tbody tr').length;

            for(let i = 2; i <= countRows + 1; i++) {
                ws["H" + i].z = "+5500000000000"; //  format the cell

                delete ws["H" + i].w; // delete old formatted text if it exists
                XLSX.utils.format_cell(ws["H" + i]); // refresh cell
            }

            return dl ?
                XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
                XLSX.writeFile(wb, (fileName + '.' + (type || 'xlsx')));
        }

        $('#runExtract').on('click', function(e) {
            let inputBuscar;

            if($('#input-buscar').val() != '') {
                inputBuscar = $('#input-buscar').val();
            }

            const isOnlyMobile = $('#only_mobile').is(":checked");

            // Capturando os valores dos inputs e garantindo um formato padronizado
            var data = {
                country: $('#pais').val() || "N/A",
                state: $('#estado').val() || "N/A",
                city: $('#cidade').val() || "N/A",
                neighborhood: $('#bairro').val() || "N/A",
                search: inputBuscar || "N/A",
                onlyMobile: $('#only_mobile').is(":checked") ? "Mobile" : "Todos"
            };

            localStorage.setItem('SpyLeads_UltimaPesquisa', JSON.stringify(data));

            // Criando a mensagem com todos os termos da pesquisa
            let message = `
                <strong>Termos da pesquisa:</strong><br>
                🔹 <b>País:</b> ${data.country} <br>
                🔹 <b>Estado:</b> ${data.state} <br>
                🔹 <b>Cidade:</b> ${data.city} <br>
                🔹 <b>Bairro:</b> ${data.neighborhood} <br>
                🔹 <b>Busca:</b> ${data.search} <br>
                🔹 <b>Apenas Mobile:</b> ${data.onlyMobile} <br><br>
                Deseja continuar com essa pesquisa?
            `;

            swal({
                title: "Confirmação de Pesquisa",
                text: message,
                html: true, // Permite HTML dentro da caixa de diálogo
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim, Pesquisar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function(confirmado) {
                if (confirmado) {
                    // Gerando um nome amigável para um arquivo Excel (sem espaços e caracteres especiais)
                    var fileName = `Relatorio_${data.country}_${data.state}_${data.city}_${data.neighborhood}_${data.search}_${data.onlyMobile}`
                        .replace(/[\s\/\\:*?"<>|]/g, '') // Remove caracteres inválidos para nome de arquivo
                    var term = `${data.country}_${data.state}_${data.city}_${data.neighborhood}_${data.search}_${data.onlyMobile}`
                        .replace(/[\s\/\\:*?"<>|]/g, '') // Remove caracteres inválidos para nome de arquivo

                    $.ajax({
                        method: "POST",
                        url: "/search",
                        data: {
                            country: $('#pais').val(),
                            state: $('#estado').val(),
                            city: $('#cidade').val(),
                            neighborhood: $('#bairro').val(),
                            search: inputBuscar,
                            onlyMobile: $('#only_mobile').is(":checked")
                        },
                        beforeSend: () => {
                            //$('#only_mobile').prop('disabled', true);
                            $('#runExtract').prop('disabled', true);
                            $('#stopExtract').prop('disabled', false);
                            $('.loading').show();
                            $('.extractionCompleted').hide();
                            $(".extractionWithDataBase").hide();
                            $("table.table tbody").empty();
                        },
                        success: (data) => {
                            if (data.success) {
                                console.log(data, data.places, data.places.length)

                                $('.loading').hide();

                                $('.extractionProgress').remove()
                                $(".extractionWithDataBase").show();

                                $('#findPhonesInDataBase').text(data.places.length || Object.keys(data.places).length);

                                // <th scope="col">Consulta</th>
                                // <th scope="col">Nome</th>
                                // <th scope="col">Endereço Completo</th>
                                // <th scope="col">Logradouro</th>
                                // <th scope="col">Número</th>
                                // <th scope="col">Complemento</th>
                                // <th scope="col">Bairro</th>
                                // <th scope="col">Cidade</th>
                                // <th scope="col">Estado</th>
                                // <th scope="col">CEP</th>
                                // <th scope="col">Latitude</th>
                                // <th scope="col">Longitude</th>
                                // <th scope="col">Categoria</th>
                                // <th scope="col">Nota</th>
                                // <th scope="col">Avaliações</th>
                                // <th scope="col">Telefone</th>
                                // <th scope="col">Site</th>

                                $.each(data.places, function(i, place) {
                                    try {

                                        let parseAddress = parseEndereco(place?.address)

                                        $('table.table > tbody:last-child')
                                            .append(`
                                                <tr>
                                                    <td>${term}</td>
                                                    <td>${place?.title || ''}</td>
                                                    <td>${place?.address || ''}</td>

                                                    <td>${parseAddress?.logradouro || ''}</td>
                                                    <td>${parseAddress?.numero || ''}</td>
                                                    <td>${parseAddress?.complemento || ''}</td>
                                                    <td>${parseAddress?.bairro || ''}</td>
                                                    <td>${parseAddress?.cidade || ''}</td>
                                                    <td>${parseAddress?.estado || ''}</td>
                                                    <td>${parseAddress?.cep || ''}</td>

                                                    <td>${place?.latitude || ''}</td>
                                                    <td>${place?.longitude || ''}</td>
                                                    <td>${place?.category || ''}</td>
                                                    <td>${place?.rating || ''}</td>
                                                    <td>${place?.ratingCount || ''}</td>
                                                    <td>${place?.phoneNumber || ''}</td>
                                                    <td>${place?.website || ''}</td>
                                                </tr>
                                            `);
                                    } catch(err) {
                                        console.log('Erro ' + err);
                                    }
                                });

                                $.ajax({
                                    method: "POST",
                                    url: "/saveFile",
                                    data: {
                                        file: doit('xlsx', true),
                                        fileName: fileName,
                                        term: term,
                                    },
                                    success: (res) => {
                                        
                                    },
                                    error: function (request, status, error) {
                                        // Reverter as ações de beforeSend em caso de erro
                                        $('#only_mobile').prop('disabled', false);
                                        $('#runExtract').prop('disabled', false);
                                        $('#stopExtract').prop('disabled', true);
                                        $('.loading').hide();
                                        $('.extractionCompleted').show();
                                        $(".extractionWithDataBase").hide();
                                    }
                                });

                                return;
                            }
                        },
                        error: () => {
                            // Reverter as ações de beforeSend em caso de erro
                            $('#only_mobile').prop('disabled', false);
                            $('#runExtract').prop('disabled', false);
                            $('#stopExtract').prop('disabled', true);
                            $('.loading').hide();
                            $('.extractionCompleted').show();
                            $(".extractionWithDataBase").hide();
                        }
                    });
                }
            });
            
        });

        function parseEndereco(endereco) {
            const resultado = {
                logradouro: '',
                numero: '',
                complemento: '',
                bairro: '',
                cidade: '',
                estado: '',
                cep: ''
            };

            // Extrair CEP (último bloco)
            const cepMatch = endereco.match(/(\d{5}-\d{3})$/);
            if (cepMatch) {
                resultado.cep = cepMatch[1];
                endereco = endereco.replace(cepMatch[0], '').trim().replace(/[\s,]+$/, '');
            }

            // Extrair estado (duas letras antes do CEP)
            const estadoMatch = endereco.match(/[-,\s]+([A-Z]{2})$/);
            if (estadoMatch) {
                resultado.estado = estadoMatch[1];
                endereco = endereco.replace(estadoMatch[0], '').trim();
            }

            // Extrair cidade (última vírgula antes do estado)
            const cidadeMatch = endereco.match(/,([^,-]+)$/);
            if (cidadeMatch) {
                resultado.cidade = cidadeMatch[1].trim();
                endereco = endereco.replace(/,([^,-]+)$/, '').trim();
            }

            // Extrair bairro (último hífen antes da cidade)
            const bairroMatch = endereco.match(/-\s*([^,-]+)$/);
            if (bairroMatch) {
                resultado.bairro = bairroMatch[1].trim();
                endereco = endereco.replace(/-\s*([^,-]+)$/, '').trim();
            }

            // Extrair logradouro, número e complemento (tentativa por padrões comuns)
            const logradouroMatch = endereco.match(/^(.+?),\s*(.*)$/);
            if (logradouroMatch) {
                resultado.logradouro = logradouroMatch[1].trim();
                const resto = logradouroMatch[2];

                // Tentativa de capturar número e complemento com base em hífens ou vírgulas
                const numeroComplemento = resto.split(/\s*-\s*/);
                resultado.numero = numeroComplemento[0]?.trim() || '';

                if (numeroComplemento.length > 1) {
                    resultado.complemento = numeroComplemento.slice(1).join(' - ').trim();
                }
            } else {
                resultado.logradouro = endereco.trim(); // fallback
            }

            return resultado;
        }

        function replaceAllOccurrences(inputString, oldStr, newStr){
            while (inputString.indexOf(oldStr) >= 0)
            {
                inputString = inputString.replace(oldStr, newStr);
            }

            return inputString;
        }
    </script>
@endpush
