<?php
$mod = 14;
require_once('./verifica_login.php');
$atraso = isset($_GET['fila_a']);
$noprazo = isset($_GET['fila']);
$todos = isset($_GET['fila_todos']);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script>
        $(document).ready(function () {
            $('#filas').DataTable(
                {
                    pageLength: 25, // Define a quantidade padrão de registros por página
                    lengthMenu: [25, 50, 100], // Define as opções de quantidade de registros
                }
            );
        });

    </script>


<body id="page-top">
    <div id="wrapper">
        <?php include './menu_sla.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './top_bar.php'; ?>
            <?php
            $msg = "";
            if (isset($_REQUEST['msg'])) {
                $id_msg = $_REQUEST['msg'];
                if ($id_msg == 1) {
                    $msg = "Prazos atualizados com sucesso!";
                }
            }
            ?>
            <div class="alerta">
                <?php if ($msg) { ?>
                    <div class="alert alert-info fade " role="alert" id="alerta" style="width: 1000px; margin: 20px">
                        <?php echo $msg; ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            // Exibir o alerta ao carregar a página
                            var alerta = document.getElementById("alerta");
                            alerta.classList.add("show");

                            // Ocultar o alerta após 2 segundos
                            setTimeout(function () {
                                alerta.classList.remove("show");
                            }, 2000);
                        });
                    </script>
                <?php } ?>
            </div>
            <div id="content">
                <div class="d-flex justify-content-center flex-wrap">

                    <div class="card mb-4 border-primary" style="width: 100%; max-width: 80%; margin-right: 25px;">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width: 100%;">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-check-square fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <div class="col mb-0">
                                    <?php
                                    if ($atraso) {
                                        $atraso = $_GET['fila_a'];
                                        ?>
                                        <span style='text-align:left;' class='h5 m-0 font-weight text-white'>
                                            <?php echo 'Você está vendo: ' . $atraso . ' | Atrasados'; ?>
                                        </span>
                                        <?php
                                    } else if ($noprazo) {
                                        $noprazo = $_GET['fila'];
                                        ?>
                                            <span style='text-align:left;' class='h5 m-0 font-weight text-white'>
                                            <?php echo 'Você está vendo: ' . $noprazo . ' | No Prazo'; ?>
                                            </span>
                                        <?php } else if ($todos) {
                                            $todos = $_GET['fila_todos'];
                                             ?>
                                             <span style='text-align:left;' class='h5 m-0 font-weight text-white'>
                                             <?php echo 'Você está vendo: ' . $todos . ' | Todos'; ?>
                                             </span>
                                        <?php } 
                                        ?>
                                </div>


                            </div>
                            <form id="form_atualiza" style="height: 10px;">
                                <input type="hidden" name="update_painel">
                                <div class="col text-right" style="max-width:30%">
                                    <button id="atualiza" name="atualiza" class="btn btn-sm text-white border"
                                        type="button">
                                        Voltar
                                    </button>&nbsp;&nbsp;
                                </div>
                        </div>
                        </form>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="filas" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tipo de Guia</th>
                                            <th scope="col">Área</th>
                                            <th scope="col">Fila</th>
                                            <th scope="col">Encaminhamento Manual</th>
                                            <th scope="col">Data de Solicitação</th>
                                            <th scope="col">Atraso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('processa_fila.php');
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php'; ?>
</body>