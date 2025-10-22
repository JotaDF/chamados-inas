<?php
//Administraçao
$mod = 9;
require_once('./verifica_login.php');

include_once('actions/ManterUsuario.php'); 
$manterUsuario = new ManterUsuario();

$id_usuario = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if($id_usuario != 0){
    $usuario    = $manterUsuario->getUsuarioPorId($id_usuario);
}
//echo $url_atual;
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

        <title>Folhas de ponto</title>

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
            <?php include './menu_rh.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <?php include './form_setor.php'; ?>
                        <!-- Project Card Example -->
                        <div class="row" style="justify-content: center;">
                                <div class="ml-3 mr-3 card shadow mb-4" style="width:100%;">
                                    <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                        <div class="col-sm ml-0" style="max-width:50px;">
                                            <i class="fa fa-file-pdf fa-2x text-white"></i>
                                        </div>
                                        <div class="col mb-0">
                                            <span style="align:left;" class="h5 m-0 font-weight text-white">Folhas de
                                                ponto - (<?=$usuario->nome ?>)</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <table id="folha_ponto"
                                            class="table-sm table-striped table-bordered dt-responsive nowrap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ANO</th>
                                                    <th scope="col">MÊS</th>
                                                    <th scope="col" class="text-center">LINK</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila">
                                                <?php include './get_folhas_ponto_geral.php'; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
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
                        <p>Deseja excluir <strong>"<span id="nome_excluir"></span>"</strong>?</p>
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
