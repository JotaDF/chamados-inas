<?php
$mod = 22;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Atendimentos Realizados</title>

    <!-- Custom fonts for this template-->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#atendimentos_realizados').DataTable();
        });

        function getDadosAtendimentoRealizado(id) {
            $.ajax({
                url: "obter_dados_agendamento_realizado.php",
                type: "GET",
                data: { id_fila: id },
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
            let descricoes = (dados.descricao || "").split(";");
            console.log(dados);
            $('#id_fila').val(dados.fila);
            $('#id').val(dados.id);
            $('#id_agendamento').val(dados.id);
            $('#nome_agendado').text(dados.nome);
            $('#cpf_agendado').text(dados.cpf);
            $('#telefone_agendado').text(dados.telefone);
            $('#situacao_agendado').text(dados.situacao);
            $('#solicitacao_agendado').text(formatarDataISO(dados.data_solicitacao));
            $('#descricao_agendado').html(descricoes.join('<br>'));
            $('#justificativa_agendado').text(dados.justificativa);
            $('#autorizacao_agendado').text(dados.autorizacao);
            $('#hora_agendada').text(dados.hora_agendada);
            $('#data_agendada').text(formatarDataISO(dados.data_agendada));
            $('#medico_perito').text(dados.medico_perito);
            $('#titulo_modal').removeClass('d-none').html("<i class='fa fa-calendar-check mr-2'></i>Dados do Agendamento");
            $('#btn_cancela').html("<i class='fa fa-times mr-1'></i>Fechar");
            $('#confirm').modal('show');
        }


        function formatarDataISO(data) {
            if (!data) return "";

            // "2025-11-18 14:42:55"
            let [dataParte] = data.split(" "); // pega só "2025-11-18"

            let [ano, mes, dia] = dataParte.split("-");

            return `${dia}/${mes}/${ano}`; // "18/11/2025"
        }

    </script>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu_atendimento_pericia.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="container-fluid">
                    <!-- Project Card Example -->
                    <div class="card mb-4 border-primary" style="max-width:1300px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-check-square fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Atendmentos
                                    Realizados</span>
                            </div>
                            <button id="exportButton" class="btn btn-sm text-white border" type="button">Exportar para
                                Excel</button>
                        </div>

                        <div class="card-body">
                            <table id="atendimentos_realizados"
                                class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Telefone</th>
                                        <th scope="col">Data Agendada</th>
                                        <th scope="col">Hora Agendada</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Resultado</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_atendimentos_realizados.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
            <?php include './rodape.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="confirm" tabindex="-1">
        <div class="modal-dialog modal-lg"> <!-- modal maior para caber os dados -->
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="titulo_modal">

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
                                <input type="hidden" name="cpf" value="<?= $dados->cpf ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Telefone</div>
                                <div id="telefone_beneficiario"><?= $dados->telefone ?></div>
                                <div id="telefone_agendado"></div>
                                <input type="hidden" name="telefone" id="telefone" value="<?= $dados->telefone ?>">
                            </div>
                        </div>
                    </div>

                    <h6 class="text-dark mb-3">
                        <i class="fa fa-user-md mr-1"></i> Dados da Fila
                    </h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Autorização</div>
                                <div id="autorizacao_agendado"></div>
                                <input type="hidden" name="autorizacao" id="autorizacao">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Solicitação</div>
                                <div id="solicitacao_agendado"></div>
                                <input type="hidden" name="solicitacao" id="solicitacao">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Situação</div>
                                <div id="situacao_agendado"></div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Justificativa</div>
                                <div id="justificativa_beneficiario"><?= $dados->justificativa ?></div>
                                <div id="justificativa_agendado"></div>
                                <input type="hidden" name="justificativa" value="<?= $dados->justificativa ?>">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Descrição</div>
                                <div id="justificativa_beneficiario"><?= $dados->justificativa ?></div>
                                <div id="descricao_agendado"></div>
                                <input type="hidden" name="justificativa" value="<?= $dados->justificativa ?>">
                            </div>
                        </div>
                    </div>

                    <h6 class="text-dark mb-3 mt-2">
                        <i class="fa fa-user-md mr-1"></i> Dados do Atendimento
                    </h6>

                    <!-- ATENDIMENTO -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">MÉDICO PERITO</div>
                                <div id="medico_perito"></div>
                            </div>

                        </div>
                        <div class="col-md-4 mb-1">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Hora Agendada</div>
                                <div id="hora_agendada"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-1">
                            <div class="border rounded p-2 bg-light">
                                <div class="small text-dark text-uppercase font-weight-bold">Data Agendada</div>
                                <div id="data_agendada"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="submit" class="btn btn-success btn-sm" data-dismiss="modal" id="btn_cancela">
                            <i class="fa fa-check mr-1"></i> Fecjar
                        </button>
                    </div>
                </div>
                <!-- Modal excluir -->
                <script>
                    document.getElementById('exportButton').addEventListener('click', function () {
                        var wb = XLSX.utils.table_to_book(document.getElementById('atendimentos_realizados'), { sheet: "Sheet 1" });
                        XLSX.writeFile(wb, "atendimentos_realizados.xlsx");
                    });
                </script>
</body>

</html>