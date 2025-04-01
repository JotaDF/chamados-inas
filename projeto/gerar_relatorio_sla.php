<?php
$mod = 14;
require('verifica_login.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Relatório SLA</title>
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
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
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
                <div class="card-body"> 
                    <?php
                    $msg = "";

                    if (isset($_REQUEST['msg'])) {
                        $id_msg = $_REQUEST['msg'];

                        if ($id_msg == 1) {
                            $msg = "SELECIONE UM FILTRO VÁLIDO!";
                            ?>
                            <script>
                                document.getElementById('atualiza').disabled = false;
                            </script>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="d-flex justify-content-center flex-wrap">
                    <div class="alerta">
                        <?php if ($msg) { ?>
                            <div class="alert alert-info fade " role="alert" id="alerta" style="width: 1000px; margin: 10px">
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
                    <div class="card mb-4 border-primay" style="width: 100%; max-width: 45%; margin-right: 25px;">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width: 100%;">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Formulário</span>
                            </div>
                        </div>
                        <?php include('./form_relatorio_sla_regulacao.php') ?>
                    </div>
                </div>
                <?php include './rodape.php'; ?>
                <!-- End of Main Content -->
            </div>

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