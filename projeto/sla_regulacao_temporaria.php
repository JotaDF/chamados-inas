<?php
$mod = 14;
require_once('actions/ManterSlaRegulacao.php');
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Confirmação Sla Regulação - INAS</title>

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
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" class="init"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sla_regulacao').DataTable({
                paging: false
            });
        });

    </script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu_sla.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>

                <div class="container-fluid">
                    <!-- Project Card Example -->
                    <script>
                        document.getElementById('envio').addEventListener('click', function () {
                            const form = document.getElementById('form_confirmacao_sla');
                            form.action = "confirma_regulacao_tmp.php"; // Define o arquivo de processamento para salvar CSV
                            form.submit(); // Envia o formulário
                        });
                        document.getElementById('cancelar').addEventListener('click', function () {
                            const form = document.getElementById('form_confirmacao_sla');
                            form.action = "confirma_regulacao_tmp.php"; // Define o arquivo de processamento para salvar CSV
                            form.submit(); // Envia o formulário
                        });
                    </script>
                    <div class="card mb-4 border-primary" style="max-width:75%">
                        <?php include './form_confirma_sla_regulacao.php'; ?>
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <!-- <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-hourglass-half fa-2x text-white"></i>
                            </div> -->
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight  text-white">Regulação</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <!-- <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button"
                                data-toggle="collapse" data-target="#form_sla_prazo" aria-expanded="false"
                                aria-controls="form_sla_prazo">
                                <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                            </button> -->
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive"> <!-- Adicionando a classe table-responsive aqui -->
                                <table id="sla_regulacao"
                                    class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center;">Autorização</th>
                                            <th scope="col" style="text-align: center;">Tipo de Guia</th>
                                            <th scope="col" style="text-align: center;">Área</th>
                                            <th scope="col" style="width:50px;">Encaminhamento Manual</th>
                                            <th scope="col" style="width:50px;">Data de Solicitação</th>
                                            <th scope="col" style="width:50px;">Caráter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_sla_regulacao_tmp.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="form_sla_2">
                            <?php include './form_confirma_sla_regulacao.php'; ?>
                        </div>
                    </div>
                    <script>
                        function Mudarestado(form_sla_prazo, form_sla_2) {
                            var elemento = document.getElementById(form_sla_prazo);
                            var elemento2 = document.getElementById(form_sla_2);
                            var countRegulacao = <?php echo count($regulacao); ?>;
                            if (countRegulacao === 0) {
                                elemento.style.display = 'none';
                                elemento2.style.display = 'none';
                            }
                        }

                        Mudarestado('form_sla_prazo', 'form_sla_2');


                    </script>
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
    <!-- Modal excluir -->
    <div class="modal fade" id="confirm" role="dialog">
        <div class="modal-dialog modal-sm">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja excluir <strong>"<span id="excluir"></span>"</strong>?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>

        </div>
    </div>

</body>

</html>