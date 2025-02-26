<?php
$mod = 2;
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
    <script>
        $(document).ready(function () {
            $('#acessos').DataTable({
                paging: false,
                searching: true
            });
        });

    </script>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_admin.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './top_bar.php'; ?>
            <div id="content">
                <div class="card mb-4 ml-2 border-primary" style="max-width:98%">
                    <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                        <div class="col-sm ml-0" style="max-width:50px;">
                            <i class="fa fa-check-square fa-2x text-white"></i>
                        </div>
                        <div class="col mb-0">
                            <span style="align:left;" class="h5 m-0 font-weight text-white">Regualizações</span>
                        </div>
                        <div class="col text-right" style="max-width:30%">
                            <form id="update" method="POST">
                            <button id="atualiza" name="atualiza" class="btn btn-sm text-white border" type="submit">
                                Atualizar Prazos
                            </button>&nbsp;&nbsp;</form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Fila</th>
                                    <th scope="col">Dentro do Prazo</th>
                                    <th scope="col">Fora do Prazo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("get_regulacao_prazo.php");
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <script>
                        document.getElementById('atualiza').addEventListener('click', function () {
                            const form = document.getElementById('update');
                            form.action = "processa_prazo_regulacao.php"; // Alterando a ação do formulário para outro controller
                            form.submit();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>