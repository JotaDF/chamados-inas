<?php
$mod = 10;
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

    <title>Painel Execução - INAS</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0">
    </script>
    <script>
        function buscarCompetenciasPorAno(ano) {
            if (ano == "") {
                $('#competencia').html('<option value="">Selecione...</option>');
                return;
            }
            $('#competencias').html('<option value="">Carregando...</option>');
            $.ajax({
                url: 'buscar_competencias.php',
                type: 'POST',
                data: { ano: ano },
                dataType: 'json',
                success: function (dados) {
                    montaSelectCompetencias(dados);
                }
            });
        }

        function montaSelectCompetencias(dados) {
            var options = '<option value="todas">Todas as competencias</option>';
            $.each(dados, function (index, valor) {
                options += '<option value="' + valor + '">' + valor + '</option>';
            });
            $('#competencia').html(options);
        }

        function validarFormulario() {
            const select = document.getElementById('ano_competencia');

            if (!select.checkValidity()) {
                select.reportValidity(); // mostra mensagem padrão do navegador
                return;
            }

            // só chega aqui se estiver válido
            atualizarGraficoPrestador();
        }
        function exportarDadosCsv() {
            let competencia = $('#competencia').val();
            let campo = "grafico_prestador";
            exportarCSV(campo, competencia);
        }

    </script>
    <style>
        .grafico {
            width: 400px;
            height: 700px;
        }

        /* CSS Personalizado */
        .form-control-xs {
            height: 24px;
            /* Altura fixa bem pequena */
            padding: 0 0.5rem;
            /* Remove padding vertical, mantém horizontal */
            font-size: 0.75rem;
            /* Fonte pequena */
            line-height: 24px;
            /* Mesma altura do campo para centralizar o texto */
            min-height: auto;
            /* Remove restrições de altura do Bootstrap */
        }

        /* Garante que o texto dentro de selects também alinhe */
        select.form-control-xs {
            padding-top: 0;
            padding-bottom: 0;
        }

        #dashboardpie {
            width: 100%;
            max-width: 600px;
            /* Largura ajustada para o gráfico de pizza */
            height: 150px;
            /* Altura ajustada para o gráfico de pizza */
            display: block;
            /* Certificar que o gráfico de pizza é um bloco */
            margin: 0 auto;
            /* Centralizar o gráfico de pizza horizontalmente */
        }
    </style>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu_execucao.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                include 'actions/ManterPagamento.php';
                include 'actions/ManterPrestador.php';
                $manterPagamento = new ManterPagamento();
                $manterPrestador = new ManterPrestador();
                $anos_competencia = $manterPagamento->getAnosCompetencia();
                ?>
                <div class="container-fluid">
                    <!-- <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a id="link_tab_ano" class="nav-link active" href="#" onclick="motraGrafico('ano')">Total
                                prestador</a>
                        </li>
                        <li class="nav-item">
                            <a id="link_tab_ano_mes" class="nav-link active" href="#"
                                onclick="motraGrafico('ano_mes')">Por competencia</a>
                        </li>
                        <li class="nav-item">
                            <a id="link_tab_assunto" class="nav-link" href="#" onclick="motraGrafico('assunto')">Total
                                por Assunto</a>
                        </li>
                        <li class="nav-item">
                            <a id="link_tab_prestador" class="nav-link active" href="#"
                                onclick="mostraGrafico('motivo')">Total por
                                Motivo</a>
                        </li>
                    </ul> -->
                    <!-- Linha para organizar os cards lado a lado -->
                    <!-- <div id="tab_ano" class="row"> -->
                    <!-- Segundo Card (Gráfico de Pizza) -->
                    <!-- <div class="ml-4 mr-4" style="width: 90%;">
                        <div class="card border-primary">
                            <div class="row ml-0 card-header py-2" style="width:100%">
                                <div class="col mb-0">
                                    <span style="align:left;" class="h6 m-0 font-weight">Processos por ano</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <a id="exporta_motivo" href="#" onclick="exportarCSV('grafico_ano')"
                                        class="btn btn-outline-success">
                                        <i class="fa fa-file-excel"></i> Exportar
                                    </a>
                                </div>
                            </div>
                            <div id="box_grafico_ano" style="width: 95%; height: 300px;">
                                <canvas id="grafico_ano" width="100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div> -->
                    <!-- <div id="tab_ano_mes" class="row"> -->
                    <!-- Primeiro Card (Gráfico de Barras) -->
                    <!-- <div class="ml-4 mr-4" style="width: 90%;">
                        <div class="card border-primary">
                            <div class="row ml-0 card-header py-2" style="width:100%">
                                <div class="col mb-0">
                                    <span style="align:left;" class="h6 m-0 font-weight">Processos por
                                        ano/mês</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <a id="exporta_motivo" href="#" onclick="exportarCSV('grafico_ano_mes')"
                                        class="btn btn-outline-success">
                                        <i class="fa fa-file-excel"></i> Exportar
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="form_painel">
                                    <div class="form-group row">
                                        <label for="ano" class="mt-1 pr-1 small">Ano</label>
                                        Ajustei o padding-right do label -->
                    <!-- <div class="col-sm-2 pl-0">
                                            <select class="form-control form-control-xs" id="ano_mes" name="[]">
                                                <?php foreach ($anos as $ano): ?>
                                                    <option value="<?= $ano ?>"><?= $ano ?></option>
                                                <?php endforeach; ?>
                                                <option value="todos">Todos</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 pl-0">
                                            <button type="button" id="gerar_ano_mes" name="enviar"
                                                class="btn btn-primary btn-sm w-100 form-control-xs"
                                                onclick="atualizarGraficoAnoMes()">Gerar</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="box_grafico_ano_mes" style="width: 95%; height: 300px;">
                                    <canvas id="grafico_ano_mes" width="100%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --->
                    <!-- Segunda Linha de graficos -->
                    <!-- <div id="tab_assunto" class="row"> -->
                    <!-- Primeiro Card (Gráfico de Barras) -->
                    <!-- <div class="w-100">
                        <div class="card mb-3 border-primary" style="max-width: 90%;">
                            <div class="ml-0 card-header py-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                   Pergunta
                    <div class="mb-0" style="font-size: 16px;">
                        Quantidade de processos por assunto
                    </div>
                    <div class="col text-right" style="max-width:20%">
                        <a id="exporta_motivo" href="#" onclick="exportarCSV('grafico_assunto')"
                            class="btn btn-outline-success">
                            <i class="fa fa-file-excel"></i> Exportar
                        </a>
                    </div>
                </div>
            </div>
            <form id="form_assunto">
                <div class="form-group row col-sm-10">
                    <div class="col-md-2">
                        <label for="arquivado" class="small">Arquivado </label>
                        <select class="form-control form-control-xs" id="arquivado_assunto" name="arquivado">
                            <option value="3" selected>Todos</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="ano" class="small">Ano</label>
                        Ajustei o padding-right do label 
                        <div>
                            <select class="form-control form-control-xs" id="ano_assunto" name="[]">
                                <?php foreach ($anos as $ano): ?>
                                    <option value="<?= $ano ?>"><?= $ano ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="ordem" class="small">Ordenar por </label>
                        <select class="form-control form-control-xs" id="ordem_assunto" name="ordem">
                            <option value="a.assunto, sa.sub_assunto">Assunto</option>
                            <option value="total DESC">Maior total</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                        <button type="button" id="gerar_assunto" name="enviar"
                            class="btn btn-primary btn-sm w-100 form-control-xs"
                            onclick="atualizarGraficoAssunto()">Gerar</button>
                    </div>

                </div>
            </form>
            <div class="card-body " style="width: 100%;">
                <div id="box_grafico_assunto" style="width: 95%; height: 800px;">
                    <canvas id="grafico_assunto" class="grafico"></canvas>
                </div>
                <br />
                </p>
            </div>
        </div>
    </div>
    </div> -->
                    <!-- terceito Linha de graficos Motivos -->

                    <div id="grafico_prestadores" class="container-fluid">
                        <!-- Primeiro Card (Gráfico de Barras) -->
                        <div class="w-100">
                            <div class="card mb-3 border-primary" style="max-width: 99%;">
                                <div class="ml-0 card-header py-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <!-- Pergunta -->
                                        <div class="mb-2" style="font-size: 16px; font-weight: 500;">
                                            Prestadores por valor de contrato
                                            <small class="text-muted ml-1">
                                                (Exibindo <span id="quantidade_exibida"
                                                    class="font-weight-bold">0</span> registros)
                                            </small>
                                        </div>
                                        <div class="col text-right" style="max-width:20%">
                                            <a id="exporta_motivo" href="#" onclick="exportarDadosCsv()"
                                                class="btn btn-outline-success">
                                                <i class="fa fa-file-excel"></i> Exportar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <form id="form_motivo">
                                    <div class="form-group row col-sm-10">
                                        <div class="col-md-2">
                                            <label for="ano" class="small">Ano</label>
                                            <!-- Ajustei o padding-right do label -->
                                            <div>
                                                <select class="form-control form-control-xs" id="ano_competencia"
                                                    name="ano_competencia"
                                                    onchange="buscarCompetenciasPorAno(this.value)" required>
                                                    <option value="">
                                                        Selecione um Exercício
                                                    </option>
                                                    <?php foreach ($anos_competencia as $ano) { ?>
                                                        <option value="<?= $ano ?>"><?= $ano ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="competencia" class="small">Competências</label>
                                            <select class="form-control form-control-xs" id="competencia" name=""
                                                required>
                                                <option value=>Selecione um Exercício</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ordem" class="small">Exibir</label>
                                            <select class="form-control form-control-xs" id="quantidade_exibicao"
                                                name="ordem">
                                                <option value="5">Selecione uma Quantidade</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                            <button type="button" id="gerar_motivo" name="enviar"
                                                class="btn btn-primary btn-sm w-100 form-control-xs"
                                                onclick="validarFormulario()">Gerar</button>
                                        </div>

                                    </div>
                                </form>
                                <div class="card-body " style="width: 100%;">
                                    <div id="box_grafico_prestador" style="width: 95%; min-height: 350px;">
                                        <canvas id="grafico_prestador" class="grafico"></canvas>
                                    </div>
                                    <br />
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php include './rodape.php'; ?>
        </div>
    </div>
    <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php require('dashboard_relatorio_execucao.php') ?>
</body>

</html>