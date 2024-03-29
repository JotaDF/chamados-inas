<?php
//Atendimento
$mod = 5;
require_once('./verifica_login.php');

include_once('./actions/ManterGuiche.php');
$manterGuiche = new ManterGuiche();
$guiche = $manterGuiche->getGuichePorUsuario($usuario_logado->id);

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

        <title>Atendimento - GDF Saúde</title>

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
        <script type="text/javascript" class="init">       
            $(document).ready(function () {
                //....
            });
            function atualizarFila() {
                $("#fila").html('Atualizando...');
                $.get( "get_fila_atendimento.php")
                .done(function(data) {
                    //var resp = JSON.parse(data);
                    //console.log(resp);
                    $("#fila").html(data);
                });

            }
            setInterval(atualizarFila, 10000);

            function atender(id, id_guiche) {
                $('#id').val(id);
                $('#nome').val(nome);
                $('#form_fila').collapse("show");
                $('#btn_cadastrar').hide();
                carregaServicos(id_servico);
            }
            function selectByText(select, text) {
                $(select).find('option:contains("' + text + '")').prop('selected', true);
            }
            function verificaFila() {
                var html = '<option value="">Selecione </option>';
                if (1+1) {

                }
                $('#servico').html(html);
            }

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
            <?php include './menu_atendimento.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <!-- Begin Page Content -->
<?php

    $atender = false;
    if(isset($guiche->id)){  
        $atender = true;
?>
    <!-- Collapsable Form -->
    <div class="card mb-4" id="atendente" style="max-width:900px">              
        <!-- Card Content - Collapse -->
        <div class="card-body card-deck d-flex justify-content-center" style="mim-width:200px">
            <div class="card bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header h4"><center>Atendente</center></div>
                <div class="card-body"><br/>
                <center><h3 class="card-title"><?=$usuario_logado->nome ?></h3></center>
                </div>
            </div>
            <div class="card bg-info mb-3 text-white" style="max-width: 18rem;">
                <div class="card-header h4"><center>Guichê</center></div>
                <div class="card-body">
                    <center><spam class="card-title" style="font-size:70px;"><b><?=$guiche->numero ?></b></spam></center>
                </div>
            </div>          
        </div>
    </div>
    <!-- /.container-fluid -->
<?php
    }
?>

                        <!-- Project Card Example -->
                        <div id="exibe">
                        </div>
                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fas fa-users fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Fila</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="filaes" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Ordem</th>
                                            <th scope="col">CPF</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Serviço</th>
                                            <th scope="col">Preferencial</th>
                                            <th scope="col">Espera</th>
                                            <th scope="col">Chamado</th>
                                            <?php
                                            if($atender){
                                            ?>
                                            <th scope="col">Atender</th>
                                            <?php
                                            }?>

                                        </tr>
                                    </thead>
                                    <tbody id="fila">
                                        <?php include './get_fila_atendimento.php'; ?>
                                    </tbody>
                                </table>
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
    </body>
</html>
