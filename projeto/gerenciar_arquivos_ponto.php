<?php
//RH
$mod = 9;
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

        <title>Gerenciar arquivos ponto</title>

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
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script type="text/javascript" class="init">
             function deleteFile(fileName, listItem) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "del_arquivo_ponto.php?file=" + fileName, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("Arquivo deletado");
                        listItem.remove();
                    }
                };
                xhr.send();
            }

            function excluir(id, visitante) {
                $('#delete').attr('href', 'del_recepcao.php?id=' + id);
                $('#excluir').text(visitante);
                $('#confirm').modal({show: true});              
            }

        </script>
        <style>
            body{
                font-size: small;
            }
            #teste{position:relative}
            #teste:hover{top:-1px;box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1)}

            .texto{
                padding: 5px;
                text-align: center;
                font-family:'Times New Roman', Times, serif, sans-serif;
                padding: 10px;
            }

            .pdf{
                background-color: #F2F2F2;
                border: solid gray 1px;
                width: 250px;
                height: 15px;
                border-radius: 3px;
                box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1);
                padding: 1px;
                
            }

            .pdf2{
                background-color: #81DAF5;
                border-top: 5px solid #2E9AFE ;
                width: 293px;
                height: relative;
                border-radius: 4px;
                padding: 4px;
            }

            .opcoes{
                float: right;
                font-size: 13px;
                font-family: Arial, Helvetica, sans-serif;
                padding: 2px;
                text-decoration: none;
                border-radius: 2px;
                box-shadow: 0px 2px 3px  0px rgba(0, 0, 0, 0.1);
                padding: 2px;
            }
        </style>
    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php include './menu_recepcao.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>

                    <div class="container-fluid">
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-address-card fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Arquivos de ponto</span>
                                </div>
                                <div class="col text-right" style="max-width:20%">
                                    <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button" data-toggle="collapse" data-target="#form_recepcao" aria-expanded="false" aria-controls="form_recepcao">
                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <div class="card-group">
                                    <?php
                                    $uploadDir = 'ponto/2024/06/';
                                    $files = array_diff(scandir($uploadDir), array('.', '..'));

                                    foreach ($files as $file) { ?>
                                        <div id='file-$file' class='col-xl-3 col-md-2 mb-4' style='max-width: 280px; max-height: 100px;'>
                                                <img src="img/pdf_icon.svg" width="60" height="60" /> <?=$file ?>
                                                <a  href="javascript:void(0);" onclick="deleteFile('<?=$file ?>', this.parentNode)"><i class='far fa-trash-alt'></i></a>
                                        </div>
                                   <?php
                                    }
                                    ?>
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
                        <p>Deseja excluir <strong>"<span id="excluir"></span>"</strong>?</p>
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
