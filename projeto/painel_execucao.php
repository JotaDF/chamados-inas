<?php
$mod = 10;
require_once('./verifica_login.php');
$origem = isset($_REQUEST['adm']) ? $_REQUEST['adm'] : 0;
$menu = "menu_execucao.php";
if ($origem == 1) {
    $menu = "menu_execucao_adm.php";
}
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
        function buscarCompetenciasNotaPagamentoPorAno(ano) {
            if (ano == "") {
                $('#competencias').html('<option value="">Selecione...</option>');
                return;
            }
            $('#competencias').html('<option value="">Carregando...</option>');
            $.ajax({
                url: 'buscar_competencias.php',
                type: 'POST',
                data: { ano: ano, tipo: 'pagamento', adm: <?= $origem ?> },
                dataType: 'json',
                success: function (dados) {
                    montaSelectCompetenciasPagamento(dados);
                }
            });
        }
        function buscarCompetenciasNotaGlosaPorAno(ano) {
            if (ano == "") {
                $('#competencia').html('<option value="">Selecione...</option>');
                return;
            }
            $('#competencias').html('<option value="">Carregando...</option>');
            $.ajax({
                url: 'buscar_competencias.php',
                type: 'POST',
                data: { ano: ano, tipo: 'glosa', adm: <?= $origem ?> },
                dataType: 'json',
                success: function (dados) {
                    montaSelectCompetenciasGlosa(dados);
                }
            });
        }

        function montaSelectCompetenciasPagamento(dados) {
            var options = '<option value="todas">Todas as competencias</option>';
            $.each(dados, function (index, valor) {
                options += '<option value="' + valor + '">' + valor + '</option>';
            });
            $('#competencia_pagamento').html(options);
        }
        function montaSelectCompetenciasGlosa(dados) {
            var options = '<option value="todas">Todas as competencias</option>';
            $.each(dados, function (index, valor) {
                options += '<option value="' + valor + '">' + valor + '</option>';
            });
            $('#competencia_glosa').html(options);
        }

        function validarFormularioPagamento() {
            const select = document.getElementById('ano_competencia_pagamento');
            if (!select.checkValidity()) {
                select.reportValidity(); // mostra mensagem padrão do navegador
                return;
            }

            // só chega aqui se estiver válido
            atualizarGraficoPagamento();
        }
        function validarFormularioGlosa() {
            const select = document.getElementById('ano_competencia_glosa');

            if (!select.checkValidity()) {
                select.reportValidity(); // mostra mensagem padrão do navegador
                return;
            }

            // só chega aqui se estiver válido
            atualizarGraficoGlosa();
        }
        function exportarDadosCsv(campo) {
            let grafico = campo.replace('grafico_nota_', '');
            let competencia = $('#competencia_' + grafico).val();
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
        <?php include './' . $menu ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                include 'actions/ManterPagamento.php';
                include 'actions/ManterCartaRecurso.php';

                $manterPagamento = new ManterPagamento();
                $manterCartaRecurso = new ManterCartaRecurso();

                $anos_competencia_pagamento = $manterPagamento->getAnosCompetencia();
                $anos_competencia_glosa = $manterCartaRecurso->getAnosCompetencia();

                $anos_competencia_pagamento_adm = $manterPagamento->getAnosCompetenciaAdm();
                $anos_competencia_glosa_adm = $manterCartaRecurso->getAnosCompetenciaAdm();

                $competencias_pagamento = $adm != "1" ? $anos_competencia_pagamento : $anos_competencia_pagamento_adm;
                $competencias_glosa = $adm != "1" ? $anos_competencia_glosa : $anos_competencia_glosa_adm;

                ?>

                <div class="container-fluid">
                    <?php if ($origem == "0") {
                        ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a id="link_tab_grafico_nota_pagamento" class="nav-link" href="#"
                                    onclick="mostraGrafico('grafico_nota_pagamento')">Notas Pagamento</a>
                            </li>
                            <li class="nav-item">
                                <a id="link_tab_grafico_nota_glosa" class="nav-link " href="#"
                                    onclick="mostraGrafico('grafico_nota_glosa')">Notas Glosa</a>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>
                    <!-- Segunda Linha de graficos -->
                    <div id="tab_grafico_nota_glosa" class="row">
                        <div id="grafico_notas_glosa" class="container-fluid">
                            <div class="w-100">
                                <div class="card mb-3 border-primary" style="max-width: 90%;">
                                    <div class="ml-0 card-header py-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <!-- Pergunta -->
                                            <div class="mb-2" style="font-size: 16px; font-weight: 500;">
                                                Prestadores por valor de glosa
                                                <small class="text-muted ml-1">
                                                    (Exibindo <span id="quantidade_exibida_glosa"
                                                        class="font-weight-bold">0</span> registros)
                                                </small>
                                            </div>
                                            <div class="col text-right" style="max-width:20%">
                                                <a id="exporta_motivo" href="#"
                                                    onclick="exportarDadosCsv('grafico_nota_glosa')"
                                                    class="btn btn-outline-success">
                                                    <i class="fa fa-file-excel"></i> Exportar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row col-sm-10">
                                        <div class="col-md-2">
                                            <label for="ano_competencia_pagamento" class="small">Execício </label>
                                            <select class="form-control form-control-xs" id="ano_competencia_glosa"
                                                name="ano_competencia_glosa"
                                                onchange="buscarCompetenciasNotaGlosaPorAno(this.value)" required>
                                                <option value="">
                                                    Selecione um Exercício
                                                </option>
                                                <?php foreach ($competencias_glosa as $ano) { ?>
                                                    <option value="<?= $ano ?>">
                                                        <?= $ano ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ano" class="small">Competência</label>
                                            <div>
                                                <select class="form-control form-control-xs" id="competencia_glosa"
                                                    name="competencia_glosa" required>
                                                    <option value="todas">Selecione um Exercício</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ordem" class="small">Exibir</label>
                                            <select class="form-control form-control-xs" id="quantidade_exibicao_glosa"
                                                name="ordem">
                                                <option value="5">Selecione uma Quantidade</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                            <button type="button" id="gerar_assunto" name="enviar"
                                                class="btn btn-primary btn-sm w-100 form-control-xs"
                                                onclick="validarFormularioGlosa()">Gerar</button>
                                        </div>

                                    </div>
                                    </form>
                                    <div class="card-body" style="width: 100%;">
                                        <div id="box_grafico_nota_glosa" style="width: 95%; min-height: 350px;">
                                            <canvas id="grafico_nota_glosa" class="grafico"></canvas>
                                        </div>
                                        <br />
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab_grafico_nota_pagamento" class="row">
                        <div id="grafico_notas_pagamento" class="container-fluid">
                            <!-- Primeiro Card (Gráfico de Barras) -->
                            <div class="w-100">
                                <div class="card mb-3 border-primary" style="max-width: 99%;">
                                    <div class="ml-0 card-header py-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <!-- Pergunta -->
                                            <div class="mb-2" style="font-size: 16px; font-weight: 500;">
                                                Prestadores por valor de contrato
                                                <small class="text-muted ml-1">
                                                    (Exibindo <span id="quantidade_exibida_nota_pagamento"
                                                        class="font-weight-bold">0</span> registros)
                                                </small>
                                            </div>
                                            <div class="col text-right" style="max-width:20%">
                                                <a id="exporta_motivo" href="#"
                                                    onclick="exportarDadosCsv('grafico_nota_pagamento')"
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
                                                <div>
                                                    <select class="form-control form-control-xs"
                                                        id="ano_competencia_pagamento" name="ano_competencia_pagamento"
                                                        onchange="buscarCompetenciasNotaPagamentoPorAno(this.value)"
                                                        required>
                                                        <option value="">
                                                            Selecione um Exercício
                                                        </option>
                                                        <?php foreach ($competencias_pagamento as $ano) { ?>
                                                            <option value="<?= $ano ?>"><?= $ano ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="competencia" class="small">Competências</label>
                                                <select class="form-control form-control-xs" id="competencia_pagamento"
                                                    name="competencia_pagamento" required>
                                                    <option value=>Selecione um Exercício</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ordem" class="small">Exibir</label>
                                                <select class="form-control form-control-xs"
                                                    id="quantidade_exibicao_pagamento" name="ordem">
                                                    <option value="5">Selecione uma Quantidade</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                                <button type="button" id="gerar_motivo" name="enviar"
                                                    class="btn btn-primary btn-sm w-100 form-control-xs"
                                                    onclick="validarFormularioPagamento()">Gerar</button>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="card-body " style="width: 100%;">
                                        <div id="box_grafico_nota_pagamento" style="width: 95%; min-height: 350px;">
                                            <canvas id="grafico_nota_pagamento" class="grafico"></canvas>
                                        </div>
                                        <br />
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include './rodape.php'; ?>
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