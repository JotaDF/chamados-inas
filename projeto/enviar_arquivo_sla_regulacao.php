<?php
$mod = 14;
require_once('./verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
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
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_sla.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="conainer-fluid">
                    <div class="card-body mt-4">
                        <div class="card mb-4 border-primary" style="max-width:1000px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0 text-right" style="max-width:50px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                        class="bi bi-upload text-white" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 0a.5.5 0 0 1 .5.5V7h2.5a.5.5 0 0 1 .354.854l-3 3a.5.5 0 0 1-.708 0l-3-3A.5.5 0 0 1 5.5 7H8V.5A.5.5 0 0 1 8 0zM3.5 10a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-4z" />
                                    </svg>
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Upload</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="row">
                                    <div class="card-body">
                                        <?php 
                                         include './form_csv.php';
                                        $msg = "";

                                        if (isset($_REQUEST['msg'])) {
                                            $id_msg = $_REQUEST['msg'];
                                        
                                            if ($id_msg == 1) {
                                                $msg = "Arquivo processado com sucesso!";
                                                ?>
                                                <script>
                                                document.getElementById('atualiza').disabled= false;
                                            </script>
                                            <?php
                                            } else if ($id_msg == 2) {
                                                $msg = "Erro ao processar arquivo!";
                                            } else if ($id_msg == 3) {
                                                $msg = "Situação atualizada com sucesso!";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alerta">
                    <?php if ($msg) {?>
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
            </div>
            <?php include './rodape.php'; ?>
        </div>
    </div>
</body>

</html>