<?php
$mod = 22;
include_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiários</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#fila_atendimentos').DataTable();
        });
        function modalPendencia(id_fila, pendencia = "") {
            $('#id_fila').val(id_fila);
            $('#pendencia').val("");
            if (pendencia != null) {
                $('#pendencia').val(pendencia);
            }
            $('#modal_pendencia').modal('show');
        }
        function geraModalAgendado(id_fila) {
            console.log(id_fila);
            $.ajax({
                url: "obter_dados_agendamento_realizado.php",
                type: "GET",
                data: { id_fila: id_fila, agendado: 1 },
                dataType: "json",
                success: function (dados) {
                    mostraModal(dados[0]);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX ERROR:", status, error);
                    console.log("RESPONSE TEXT:", xhr.responseText);
                    alert("Erro ao carregar dados (ver console).");
                }
            });
        }

        function mostraModal(dados) {
            $('#confirm').modal('show');
        }

    </script>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_atendimento_pericia.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="container-fluid">
                    <div class="card mb-4 border-primary" style="max-width:1200px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-user fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Fila Perícia Eco</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="fila_atendimentos"
                                class="table-sm table-striped table-bordered dt-responsive wrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Autorização</th>
                                        <th scope="col">Data Solicitação</th>
                                        <th scope="col">Situação</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Telefone</th>
                                        <th scope="col" style="width: 10%">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include('./get_fila_pericia_eco.php'); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./rodape.php') ?>
        </div>
    </div>
    <div class="modal fade" id="modal_pendencia" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="registrar_pendencia_fila.php" method="POST">
                    <input type="hidden" name="id_fila" id="id_fila">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar pendência</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" name="pendencia" id="pendencia"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="confirmar">Confirmar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal fade" id="confirm" tabindex="-1">
        <div class="modal-dialog modal-lg"> <!-- modal maior para caber os dados -->
            <div class="modal-content">
                <p id="mensagem" class="alert alert-success mt-2 d-none" role="alert"></p>
                <!-- HEADER -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="titulo_modal">
                        <b>Informações do agendamento </b>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <!-- Dados do paciente em mini-cards -->
                    <h6 class="text-secondary mb-3">
                        <i class="fa fa-user mr-1"></i> Dados do Beneficiário
                    </h6>
                    <!-- DADOS DO BENEFICIÁRIO -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Nome</div>
                                <div id="nome_agendado"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">CPF</div>
                                <div id="cpf_agendado"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Telefone</div>
                                <div id="telefone_agendado"></div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-dark mb-3">
                        <i class="fa fa-user-md mr-1"></i> Dados da Fila
                    </h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Data Agendada</div>
                                <div id="autorizacao_agendado"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Hora Agendada</div>
                                <div id="solicitacao_agendado"></div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer  d-flex">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="btn_cancela">
                            <i class="fa fa-times mr-1"></i> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>