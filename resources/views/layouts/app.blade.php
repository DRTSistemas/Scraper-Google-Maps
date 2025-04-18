<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>{{ config('app.name') }}</title>

        <!-- Favicon -->

        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">

        <!-- Fonts -->

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Icons -->

        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">

        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- Argon CSS -->

        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link type="text/css" href="{{ asset('site') }}/lib/enjoyhint.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link href="
        https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css
        " rel="stylesheet">

        <style>
            .dataTables_length,
            .dataTables_filter {
                display: none;
            }
        </style>
        <style type="text/css">
            .dataTables_paginate a {
                padding: 10px !important;
            }
            .dt-buttons {
                margin-bottom: 10px;
                text-align: center;
            }
            .buttons-csv {
                color: #fff;
                border-color: #172b4d;
                background-color: #172b4d;
                box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
            }
            .buttons-excel {
                color: #fff;
                border-color: #5e72e4;
                background-color: #5e72e4;
                box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
            }
        </style>
        <style type="text/css">
            .bg-default {
                background: #202020 !important;
            }
            .fill-default {
                fill: #202020 !important;
            }
            .bg-gradient-primary {
                background: #FFF !important;
            }
            .text-primary {
                color: #202020 !important;
            }
            .selectWrapper {
                width: 100%;
                overflow: hidden;
                position: relative;
                /* border: 1px solid #bbb; */
                border-radius: 2px;
                /* background:#FFFFFF url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2211%22%20height%3D%2211%22%20viewBox%3D%220%200%2011%2011%22%3E%3Cpath%20d%3D%22M4.33%208.5L0%201L8.66%201z%22%20fill%3D%22%2300AEA9%22%2F%3E%3C%2Fsvg%3E') right 13px center no-repeat; */
                border-radius: .375rem;
            }

            .selectWrapper select {
                padding: 12px 40px 12px 20px;
                font-size: 18px;
                line-height: 18px;
                width: 100%;
                border: none;
                box-shadow: none;
                background: transparent;
                background-image: none;
                -webkit-appearance: none;
                outline: none;
                cursor: pointer;
                -moz-appearance: none;
                text-indent: 0.01px;
                text-overflow: ellipsis;
            }
        </style>
        <style>
            .table-responsive nav {
                display: flex;
                justify-content: flex-end;
                padding: 10px;
            }
            .table-responsive nav div:nth-child(2) div:nth-child(2) {
                display: none;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <style>
            .dataTables_length,
            .dataTables_filter {
                display: none;
            }
        </style>
        <style type="text/css">
            .dataTables_paginate a {
                padding: 10px !important;
            }
        </style>
        
        <style type="text/css">
        ::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background: #F5F5F5;
        }

        ::-webkit-scrollbar
        {
            width: 6px;
            height: 6px;
            background: linear-gradient(30deg, #1baacc 0%, #20e99d 100%);
        }

        ::-webkit-scrollbar-thumb
        {
            background: linear-gradient(30deg, #1baacc 0%, #20e99d 100%);
        }

        .header {
                background: #5e72e4;
        }
        </style>

        @stack('styles')
    </head>

    <body class="{{ $class ?? '' }}">

        @auth()

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                @csrf

            </form>

            <div class="modal fade" id="Modal2FA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" id="main-modal-size" role="document">
                    <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header" id="main-modal-header">
                                
                            </div>
                            <div class="modal-body" id="main-modal-body">
                                
                            </div>
                            <div class="modal-footer" id="main-modal-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalDisabled2FA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" id="main-modal-size" role="document">
                    <div class="modal-content">
                        <div class="modal-content">
                            <div class="modal-header" id="main-modal-header">
                                
                            </div>
                            <div class="modal-body" id="main-modal-body">
                                <div class="text-center">
                                    <label>Insira o código do Google Authenticator.</label>
                                </div>
                                <input type="password" name="one_time_password" class="form-control form-control-lg" placeholder="**********" />
                            </div>
                            <div class="modal-footer" id="main-modal-footer">
                                <button type="button" class="btn btn-outline-secondary" onclick="Cancel2FaVerify()">Cancelar</button>
                                <button type="button" class="btn btn-dark" onclick="Disabled2Fa()">Verificar 2FA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.navbars.sidebar', ['page' => $page])

        @endauth


        <div class="main-content">
            @include('layouts.navbars.navbar', ['page' => $page])
            @yield('content')
        </div>


        @guest()

            @include('layouts.footers.guest')

        @endguest


        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/shim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/blob-polyfill/7.0.20220408/Blob.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="
        https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js
        "></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @stack('js')


        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script type="text/javascript">
            $('#from, #to').datepicker({dateFormat: 'dd/mm/yy'});
        </script>

        <script>
            const SUPORTE_URL = {!! json_encode(env('SUPORTE_URL')) !!}
        </script>

        @auth
            <script>
                const API_TOKEN = {!! json_encode(auth()->user()->api_token) !!}
            </script>
            <script>
                $('#openSupport').on('click', function () {
                    $.get('/support', function (response) {
                        window.location.href = response.redirect;
                    });
                });
            </script>
            <script>
                function copyInvitation() {
                    var link = "{{route('register')}}/{{ Auth::user()->username }}"

                    var dummy = document.createElement("textarea");
                    // to avoid breaking orgain page when copying more words
                    // cant copy when adding below this code
                    // dummy.style.display = 'none'
                    document.body.appendChild(dummy);
                    //Be careful if you use texarea. setAttribute('value', value), which works with "input" does not work with "textarea". – Eduard
                    dummy.value = link;
                    dummy.select();
                    document.execCommand("copy");
                    document.body.removeChild(dummy);

                    $("#indicationLink").modal('show');
                    // alert('Your link as been copied to clipboard')
                }
            </script>
            <script>
                $('#Modal2FA').on('show.bs.modal', function (event) {
                    $.ajax({
                        url:'enable-2fa',
                        datatype:'json',
                        method:"post",
                        success:function(response){
                            if(response.status==true){
                                var body=`
                                    <div class="text-center">
                                        <img src="${response.data.qr}" />
                                        <label>Por favor, escaneie este código QR pelo aplicativo Google Authenticator. Clique em verificar se ele foi escaneado.</label>
                                    </div>
                                    `;
                                $('#Modal2FA #main-modal-body').html(body);
                                $('#Modal2FA #main-modal-footer').html(`
                                    <button type="button" class="btn btn-outline-secondary" onclick="Cancel2FaVerify()">Cancelar</button>
                                    <button type="button" class="btn btn-dark" onclick="confirm2Fa('${response.data.secretKey}')">Verificar 2FA</button>
                                `);
                            }
                        },
                        error: function(xhr, status, error) {
                            
                        }
                    });
                });

                window.Disabled2Fa = function(){
                    $.ajax({
                        url:'disabled-2fa',
                        datatype:'json',
                        method:"post",
                        data: {
                            one_time_password: $('input[name="one_time_password"]').val(), // Captura o valor do input
                            _token: "{{ csrf_token() }}" // Adiciona o CSRF token do Laravel
                        },
                        success:function(response){
                            if(response.status==true){
                                $('#ModalDisabled2FA').modal('hide');
                                swal({
                                    type: 'success',
                                    title: 'Desabilitar 2FA',
                                    text: 'Verificação de dois fatores desabilitada com sucesso. A página será atualizada automaticamente em 3 segundos.',
                                });

                                setTimeout(function() {
                                    location.reload()
                                }, 3000);
                            } else {
                                swal({
                                    type: 'error',
                                    title: 'Desabilitar 2FA',
                                    text: 'A senha de uso único é inválida.',
                                    button: "Tentar novamente.",
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            
                        }
                    });
                }

                window.Cancel2FaVerify = function(){
                    $('#Modal2FA').modal('hide');
                    window.location.reload();
                }

                function confirm2Fa(secretKey) {
                    swal({
                        title: "Você já escaneou o QR Code?",
                        text: "Certifique-se de que o código foi escaneado no Google Authenticator antes de prosseguir.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sim, Verificar",
                        cancelButtonText: "Cancelar",
                        closeOnConfirm: true
                    }, function(confirmado) {
                        if (confirmado) {
                            Verify2Fa(this, secretKey);
                        }
                    });
                }

                window.Verify2Fa=function(btn,secretKey){
                    btn.disabled=true;
                    $.ajax({
                        url:'verify-2fa',
                        datatype:'json',
                        method:"POST",
                        data:{secretKey},
                        success:function(response){
                            btn.disabled=false;
                            $('#Modal2FA').modal('hide');
                            swal({
                                type: 'success',
                                title: 'Verificar 2FA',
                                text: 'Verificação de dois fatores adicionada com sucesso. A página será atualizada automaticamente em 3 segundos.',
                            });

                            setTimeout(function() {
                                location.reload()
                            }, 3000);
                        }
                    })
                }
            </script>
        @endauth
    </body>

</html>
