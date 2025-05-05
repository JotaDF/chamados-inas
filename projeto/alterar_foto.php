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

        <title>INAS - Alterar foto do perfil</title>

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

                    <div class="container-fluid">
                        <!-- Project Card Example -->
                        <div class="card mb-4 border-primary" style="max-width:900px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-id-card fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Alterar foto do perfil</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="max-width:900px">
                            <div>
                                <h4>Imagem do perfil: <strong><?= $usuario_logado->nome ?></strong></h4><hr>
                            </div>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $usuario_logado->id ?>"/>
                                <label for="conteudo">Selecionar imagem:</label>
                                <input type="file" name="img_perfil" accept=".jpg,.jpeg" class="form-control" required>

                                <div align="center">
                                    <button type="submit" class="btn btn-success">Enviar imagem</button>
                                </div>
                            </form>

                            <hr>

                            <?php
                            if (isset($_FILES['img_perfil'])) {

                                $ext = strtolower(substr($_FILES['img_perfil']['name'], -4)); //Pegando extensão do arquivo
                                if($ext=='jpeg'){
                                    $ext='.jpeg';
                                }
                                $new_name = $usuario_logado->id . $ext; //Definindo um novo nome para o arquivo
                                echo "EXT:|" . $ext . "| NOME: " . $new_name;
                                $dir = './ft/'; //Diretório para uploads
                                if (file_exists($dir . $usuario_logado->id . '.jpg' )) {
                                    echo "Achou JPG!";
                                    unlink($dir .$usuario_logado->id . '.jpg');
                                } else if (file_exists($dir . $usuario_logado->id . '.jpeg' )) {
                                    echo "Achou JPEG!";
                                    unlink($dir . $usuario_logado->id . '.jpeg');
                                }
                                move_uploaded_file($_FILES['img_perfil']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo
                                echo '<div class="alert alert-success" role="alert" align="center">
          <img src="./ft/' . $new_name . '" class="img img-responsive img-thumbnail" width="200"> 
          <br>
          Imagem enviada com sucesso!
          <br></div>';
                            } else {
                                $dir = './ft/';
                                $imagem = '';
                                if (file_exists($dir .$usuario_logado->id . '.jpg' )) {
                                    $imagem = $dir . $usuario_logado->id . '.jpg';
                                } else if (file_exists($dir .$usuario_logado->id . '.jpeg' )) {
                                    $imagem = $dir . $usuario_logado->id . '.jpeg';
                                }
                                echo '<div class="alert alert-light" role="alert" align="center">
          <img src="' . $imagem . '" class="img img-responsive img-thumbnail" width="200"> 
          <br>
          Imagem atual!
          <br></div>';
                            }
                            ?>

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
