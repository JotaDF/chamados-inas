<?php
//Inicio
$mod = 1;
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

        <title>SISTEMAS INAS-DF</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico" />
        <!------ Include the above in your HEAD tag ---------->

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <style>
            body{
                font-size: small;
            }
        </style>
    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
        <?php include './menu.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    
                    <!-- Links sistemas -->
                    <div class="card-group">
                    <?php
                    foreach ($acessos as $acesso) {
                        if($acesso->id_modulo != 1){
                    ?> 
                        <div class="col-xl-3 col-md-2 mb-2" style="max-width: 280px; max-height: 100px;">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                                <a href="<?=$acesso->link ?>">
                                                    <img src="img/<?=$acesso->icone ?>" width="70">
                                                </a> <?=$acesso->modulo ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                    ?> 
                    <!-- End of Links sistemas -->
                </div>
                <!-- End of Main Content -->                
            </div>
            <!-- End of Content Wrapper -->
            <?php include './rodape.php'; ?>
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

    </body>

</html>
