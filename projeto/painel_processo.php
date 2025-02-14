<?php
// Administração
$mod = 2;
require_once('./verifica_login.php');
include('actions/ManterProcesso.php');
$p = new ManterProcesso();
$anos = $p->getAnos();
;
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
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu_admin.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="container-fluid">
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            <i class="fi fi-rs-chart-pie-alt"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Gráfico de Barras</span>
                            </div>
                            <div class="col text-right" style="max-width:20%"></div>
                        </div>
                        <div class="card-body">
                            <form id="form_painel">
                                <div class="form-group row">
                                    <label for="ano" class="col-sm-2 col-form-label">Ano</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-sm" id="ano" name="[]">
                                            <?php foreach ($anos as $ano): ?>
                                                <option value="<?= $ano ?>"><?= $ano?></option>
                                                <?php endforeach; ?>
                                                <option value="todos">Todos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row float-right">
                                    <button type="submit" name="enviar" class="btn btn-primary btn-sm">
                                         Gerar
                                    </button>
                                </div>
                            </form>
                                <canvas id="meuGrafico" width="200" height="100">
                                    <?php
                                    include('dashboard_bar.php');
                                    ?>
                                </canvas>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            <i class="fi fi-rs-chart-pie-alt"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Gráfico de Barras</span>
                            </div>
                            <div class="col text-right" style="max-width:20%"></div>
                        </div>
                        <div class="card-body">
                            <form id="form_painel_pie">
                                <div class="form-group row">
                                    <label for="ano" class="col-sm-2 col-form-label">Ano</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-sm" id="ano2" name="[]">
                                                <option value="todos">Todos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row float-right">
                                    <button type="submit" name="enviar" class="btn btn-primary btn-sm">
                                         Gerar
                                    </button>
                                </div>
                            </form>
                                <canvas id="dashboardpie" width="200" height="100"> </canvas>
                                    <?php
                                    include('dashboard_pie.php');
                                    ?>
                               
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
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

</html>