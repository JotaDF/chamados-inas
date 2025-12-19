<?php
// Juridico
$mod = 6;
require_once('./verifica_login.php');
include('actions/ManterProcesso.php');
$p = new ManterProcesso();
$anos = $p->getAnos();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Chamados - INAS</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0">
    </script>
    <style>
        .grafico {
            width: 400px;
            height: 700px;
        }
        #bar {
            width: 100%;
            max-width: 650px;
            /* Limitar a largura do card-body */
            height: 400px;
            /* Limitar a largura do card-body */
            margin: 0 auto;
            /* Limitar a largura do card-body */
        }

        #pie {
            width: 100%;
            max-width: 650px;
            /* Limitar a largura do gráfico de pizza */
            height: 420px;
            /* Limitar a largura do gráfico de pizza */
            margin: 0 auto;
            /* Limitar a largura do gráfico de pizza */
        }


        #barra {
            width: 100%;
            max-width: 500px;
            /* Largura ajustada para o gráfico de barras */
            height: 250px;
            /* Altura ajustada para o gráfico de barras */
            display: block;
            /* Certificar que o gráfico de barras é um bloco */
            margin: 0 auto;
            /* Centralizar o gráfico de barras horizontalmente */
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
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu_juridico.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="container-fluid">
                    <!-- Linha para organizar os cards lado a lado -->
                    <div class="row">
                        <!-- Primeiro Card (Gráfico de Barras) -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary" id="bar">
                                <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                    <div class="col-sm ml-0" style="max-width:50px;">
                                        <i class="fi fi-rs-chart-pie-alt"></i>
                                    </div>
                                    <div class="col mb-0">
                                        <span style="align:left;" class="h5 m-0 font-weight text-white">Gráfico de
                                            Barras</span>
                                    </div>
                                    <div class="col text-right" style="max-width:20%"></div>
                                </div>
                                <div class="card-body">
                                    <form id="form_painel">
                                        <div class="form-group row">
                                            <label for="ano" class="col-sm-2 col-form-label mb-0 pr-1">Ano</label>
                                            <!-- Ajustei o padding-right do label -->
                                            <div class="col-sm-8 pl-0">
                                                <select class="form-control form-control-sm" id="ano" name="[]">
                                                    <?php foreach ($anos as $ano): ?>
                                                        <option value="<?= $ano ?>"><?= $ano ?></option>
                                                    <?php endforeach; ?>
                                                    <option value="todos">Todos</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <button type="submit" name="enviar"
                                                    class="btn btn-primary btn-sm w-100">Gerar</button>
                                            </div>
                                        </div>
                                    </form>


                                    <canvas id="barra" width="500" height="250"></canvas>
                                    <?php include('dashboard_bar.php'); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Segundo Card (Gráfico de Pizza) -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary" id="pie">
                                <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                    <div class="col-sm ml-0" style="max-width:50px;">
                                        <i class="fi fi-rs-chart-pie-alt"></i>
                                    </div>
                                    <div class="col mb-0">
                                        <span style="align:left;" class="h5 m-0 font-weight text-white">Gráfico de
                                            Pizza</span>
                                    </div>
                                    <div class="col text-right" style="max-width:20%"></div>
                                </div>
                                <div class="container-fluid">

                                    <canvas id="dashboardpie" width="550" height="370">
                                        <?php include('dashboard_pie.php'); ?>
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Segunda Linha de graficos -->
                    <div class="row">
                        <!-- Primeiro Card (Gráfico de Barras) -->
                        <div class="w-100">                            
                            <div class="card mb-3 border-primary" style="max-width: 99%;">
                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <!-- Pergunta -->
                                        <div class="mb-0" style="font-size: 16px;">
                                            Quantidade de processos por assunto
                                        </div>
                                    </div>
                                </div>
                                <form id="form_assunto">
                                    <div class="form-group row col-sm-10">
                                        <div class="col-md-2">
                                            <label for="arquivado">Arquivado </label>
                                            <select class="form-control form-control-sm" id="arquivado_assunto" name="arquivado">
                                                <option value="3" selected>Todos</option>
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select> 
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ano">Ano</label>
                                            <!-- Ajustei o padding-right do label -->
                                            <div>
                                                <select class="form-control form-control-sm" id="ano_assunto" name="[]">
                                                    <?php foreach ($anos as $ano): ?>
                                                        <option value="<?= $ano ?>"><?= $ano ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" id="gerar_assunto" name="enviar"
                                                    class="btn btn-primary btn-sm w-100" onclick="atualizarGraficoAssunto()">Gerar</button> 
                                        </div>
                                        
                                    </div>
                                </form>
                                <div class="card-body " style="width: 80%;">
                                    <div style="width: 80%; height: 800px;">
                                        <canvas id="grafico_assunto" class="grafico" ></canvas>  
                                    </div>
                                    <br />
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- terceito Linha de graficos Motivos -->
                    <div class="row">
                        <!-- Primeiro Card (Gráfico de Barras) -->
                        <div class="w-100">                            
                            <div class="card mb-3 border-primary" style="max-width: 99%;">
                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <!-- Pergunta -->
                                        <div class="mb-0" style="font-size: 16px;">
                                            Quantidade de processos por motivo
                                        </div>
                                    </div>
                                </div>
                                <form id="form_motivo">
                                    <div class="form-group row col-sm-10">
                                        <div class="col-md-2">
                                            <label for="arquivado">Arquivado </label>
                                            <select class="form-control form-control-sm" id="arquivado_motivo" name="arquivado">
                                                <option value="3" selected>Todos</option>
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select> 
                                        </div>
                                        <div class="col-md-2">
                                            <label for="ano">Ano</label>
                                            <!-- Ajustei o padding-right do label -->
                                            <div>
                                                <select class="form-control form-control-sm" id="ano_motivo" name="[]">
                                                    <?php foreach ($anos as $ano): ?>
                                                        <option value="<?= $ano ?>"><?= $ano ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" id="gerar_motivo" name="enviar"
                                                    class="btn btn-primary btn-sm w-100" onclick="atualizarGraficoMotivo()">Gerar</button> 
                                        </div>
                                        
                                    </div>
                                </form>
                                <div class="card-body " style="width: 80%;">
                                    <div style="width: 80%; height: 800px;">
                                        <canvas id="grafico_motivo" class="grafico" ></canvas>
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
    <?php require('dashboard_relatorio_processo.php') ?>
</body>

</html>
