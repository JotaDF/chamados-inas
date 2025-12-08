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
                        <div class="ml-3 mb-2" style="max-width: 600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/planejamento_estrategico_final_13_03_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Planejamento Estratégico Institucional INAS 2024 - 2027
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    
                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/mapa_estrategico_inas.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Mapa Estratégico INAS 2024 - 2027
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/codigo_de_etica_e_conduta_dos_servidores_do_inas.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Código de Ética e Conduta dos Servidores do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>    
                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/codigo_de_conduta_inas_30_04_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Manual - Cartilha Ética e Conduta dos Servidores do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>     

                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/politica_privacidade_portaria_77_22_de_julho_de_2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Política de Privacidade do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div> 

                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/programa_integridade_inas_26-09-2024.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Programa de Integridade do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div> 
                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/portaria_de_substituicoes_13-10-2025.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">Portaria de Substituições do INAS
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div> 
                        <div class="ml-3 mb-2" style="max-width:  600px; max-height: 100px;">
                            <a class="text-decoration-none" target="_blank" href="documentos/instrucao_4_27_11_2025.pdf">
                            <div class="card border-left-primary h-100 shadow">
                                <div class="card-body p-3">
                                    <div class="row no-gutters align-items-center">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                            <img src="img/pdf.svg" width="30">INSTRUÇÃO Nº 04, DE 27 DE NOVEMBRO DE 2025
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
    </body>

</html>
