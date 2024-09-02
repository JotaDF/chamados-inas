<?php

date_default_timezone_set('America/Sao_Paulo');
//Documentos
$mod = 11;
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

        <title>Documentos INAS</title>

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
                    <div style="width: 900px;">
                        <h1 class="h3 ml-3 mb-3 text-gray-800">Documentos Institucionais</h1>
                        <div class="ml-3 mb-4" style="max-width: 600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/planejamento_estrategico_final_13_03_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="45">Planejamento Estratégico Institucional INAS 2024 - 2027
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    
                        <div class="ml-3 mb-4" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/mapa_estrategico_inas.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="45">Mapa Estratégico INAS 2024 - 2027
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="ml-3 mb-4" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/codigo_de_etica_e_conduta_dos_servidores_do_inas.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="45">Código de Ética e Conduta dos Servidores do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>    
                        <div class="ml-3 mb-4" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/codigo_de_conduta_inas_30_04_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="45">Manual - Cartilha Ética e Conduta dos Servidores do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>     

                        <div class="ml-3 mb-4" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/politica_privacidade_portaria_77_22_de_julho_de_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="45">Política de Privacidade do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div> 
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
        <!-- Modal -->
        <div class="modal fade" style="max-width: 650px;" id="publicidade" tabindex="-1" role="dialog" aria-labelledby="TituloPublicidade" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloPublicidade">Notícias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-3 col-md-2 mb-4">
                        <div class="row no-gutters align-items-center">
                            <img src="publicidade/imagen.jpg" width="100%"/>
                            <br/>
                            <img src="publicidade/imagen1.jpg" width="100%"/>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal -->


        <?php
        require_once('./actions/ManterEnquete.php');
        $db_enquete = new ManterEnquete();
        $enquete = $db_enquete->getEnqueteAtiva();

        if($enquete->id > 0){
            if (!$db_enquete->jaVotou($enquete->id, $usuario_logado->id)) {

            $opcoes = $db_enquete->getOpcoesEnquete($enquete->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" style="" id="enquete" tabindex="-1" role="dialog" aria-labelledby="TituloEnquete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloEnquete">Enquete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-3 col-md-2 mb-4" style="max-width: 650px;">
                        <div class="row no-gutters align-items-center">
                            <div class="card border-dark mb-3" style="max-width: 100%;">
                                <div class="card-header"><?=$enquete->descricao ?></div>
                                <div class="card-body text-dark">
                                    <h6 class="card-title">Marque sua opção</h6>
                                    <p class="card-text">
                                    <form id="form_cadastro" action="save_voto_enquete.php" method="post">
                                        <input type="hidden" id="id_enquete" name="id_enquete" value="<?=$enquete->id ?>"/>
                                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>"/>
                                        <?php
                                        //opçoes
                                        $txt_required = "required";
                                        foreach ($opcoes as $obj) {
                                            ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="voto" value="<?=$obj->id ?>" <?=$txt_required ?>>
                                                <label class="form-check-label" for="voto">
                                                    <?=$obj->opcao ?>
                                                </label>
                                            </div>
                                            <?php
                                            $txt_required = "";
                                        }
                                        ?>
                                            <div class="form-group row float-right">
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Enviar</button>
                                                &nbsp;&nbsp;&nbsp;
                                            </div>
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal -->
        <?php
            }
        }
        ?>
    </body>

</html>
