<?php
//Atendimento
$mod = 1;
require_once('./verifica_login.php');

$lida = isset($_REQUEST['lida']) ? $_REQUEST['lida'] : 0;
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

        <title>Gerenciar notificações</title>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script type="text/javascript" class="init">         

            $(document).ready(function () {
                $("#checkall").click(function () {
                    $(".cb-element").prop("checked", this.checked);
                });

                $('.cb-element').click(function () {
                    if ($('.cb-element:checked').length == $('.cb-element').length) {
                        $('#checkall').prop('checked', true);
                    } else {
                        $('#checkall').prop('checked', false);
                    }
                });
                
            });
        </script>
        <style>
            body{
                font-size: small;
            }
        </style>
    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php include './menu_notificacoes.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <!-- Project Card Example -->
                        <form id="form_notificacoes" action="ler_minhas_notificacoes.php" method="post">
                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fas fa-bell fa-fw text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <?php
                                    $txt_lida = "Não lidas";
                                    if ($lida === 1) {
                                        $txt_lida = "Lidas";
                                    }
                                    ?>
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Minhas Notificações <?=$txt_lida ?></span>
                                </div>
                                <?php
                                if ($lida === 0) {
                                ?>
                                <div class="col text-right" style="max-width:30%">
                                    <button id="btn_cadastrar" class="btn btn-sm text-white border" type="submit">
                                        <i class="fas fa-save text-white" aria-hidden="true"></i> Salvar
                                    </button>&nbsp;&nbsp;
                                    <input class="text-right" type="checkbox" name="all" id="checkall" style="margin-right: 5px !important;">Marcar todas
                                </div>
                                <?php
                                }
                                ?>
                            </div>                            

                            <div class="card-body">
                                <table id="notificacoes" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ID</th>
                                            <th scope="col" class="text-center">Mensagem</th>
                                            <th scope="col" class="text-center">Tipo</th>                                            
                                            <th scope="col" class="text-center">Data</th>
                                            <th scope="col" class="text-center">Ver</th>
                                            <th scope="col" class="text-center">Marcar como lida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include './get_minhas_notificacoes.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
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
