<?php

date_default_timezone_set('America/Sao_Paulo');
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
        <script type="text/javascript" class="init">
            <?php
	   //print_r($usuario_logado);
            //if (isset($usuario_logado->cargo) && $usuario_logado->cargo != "Assessor Especial" && $usuario_logado->cargo != "Assessor" && $usuario_logado->cargo != "Analista em Políticas Públicas e Gestão Governamental" && $usuario_logado->cargo != "Estagiária" && $usuario_logado->cargo != "Estagiário") {
                ?>
            $(document).ready(function () {
                $("#evento").modal('show');
                $("#enquete").modal('show');
            });
            <?php
            //}
            ?>
        </script>
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
                    <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <!-- Links sistemas -->
                            <div class="card-group">
                            <?php
                            foreach ($acessos as $acesso) {
                                if($acesso->id_modulo != 1){
                                    $request = "";
                                    if ($acesso->id_modulo == 15 || $acesso->id_modulo == 19) {
                                        $request = "?texto=". $db_usuario->encryptarMensagem("nome=".$usuario_logado->nome."&login=".$usuario_logado->login."&matricula=".$usuario_logado->matricula."&perfil=".$db_usuario->getAcessoUsuario($usuario_logado->id,15));
                                    }
                            ?> 
                                <div class="col-xl-3 col-md-2 mb-4" style="max-width: 280px; max-height: 100px;">
                                    <a class="text-decoration-none" href="<?=$acesso->link . $request ?>">
                                    <div class="card border-left-primary h-100 shadow">
                                        <div class="card-body">
                                            
                                            <div class="row no-gutters align-items-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                                    <img src="img/<?=$acesso->icone ?>" width="70"><?=$acesso->modulo ?>
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        //Agenda
                        if($usuario_logado->agenda == 1){
                        ?>
                            <div class="col-xl-3 col-md-2 mb-4" style="max-width: 280px; max-height: 100px;">
                                <a class="text-decoration-none" href="agendas.php">
                                <div class="card border-left-success h-100 shadow">
                                    <div class="card-body">
                                        
                                        <div class="row no-gutters align-items-center">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                                <img src="img/agenda.svg" width="70">Agenda
                                            </div>                                        
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php
                        } else {
                            require_once('./actions/ManterAgenda.php');
                            $db_agenda = new ManterAgenda();
                            if(count($db_agenda->getAgendasQueAcesso($usuario_logado->id)) > 0){
                                ?>
                                <div class="col-xl-3 col-md-2 mb-4" style="max-width: 280px; max-height: 100px;">
                                    <a class="text-decoration-none" href="agendas.php">
                                    <div class="card border-left-success h-100 shadow">
                                        <div class="card-body">
                                            
                                            <div class="row no-gutters align-items-center">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 mb-0 w-100">
                                                    <img src="img/agenda.svg" width="70">Agenda
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            <?php 
                            }
                        }
        ?>
                    </div>
                    <div class="col">
                        <div class="col-xl-3 col-md-2 mb-4" style="max-width: 480px;">
                            <span class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/aniversario.svg" width="30" /> &nbsp;&nbsp;&nbsp;<b>Aniversariantes do mês:</b></span> 
                            <div class="row no-gutters align-items-center">
                                <?php include './get_aniversariantes.php'; ?>
                            </div>
                        </div>
                    </div> <!-- div col-->
                    </div> <!-- div row-->
                    </div> <!-- div container-->

                    <!-- End of publicidade
                    <div class="col-xl-3 col-md-2 mb-4" style="max-width: 410px;">
                        <div class="row no-gutters align-items-center">
                            <img src="publicidade/imagem3.jpg" width="100%" data-toggle="modal" data-target="#publicidade"/>
                        </div>
                    </div>
                    -->
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

<?php
        require_once('./actions/ManterEvento.php');
        $db_evento = new ManterEvento();
        $evento = $db_evento->getEventoAtivo();

        if($evento->id > 0){
            $inscrito = false;
            if ($evento->inscreve == 1) {
                $inscrito = $db_evento->jaInscreveu($evento->id, $usuario_logado->id);
            }
        ?>
        <!-- Modal -->
        <div class="modal fade" style="" id="evento" tabindex="-1" role="dialog" aria-labelledby="TituloEvento" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloEvento"><?=$evento->titulo ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-3 col-md-2 mb-4" style="max-width: 650px;">
                        <div class="row no-gutters align-items-center">
                            <div class="card border-dark mb-3" style="max-width: 100%;">
                                <div class="card-body text-dark">
                                    <?php
                                    $uploadDir = 'eventos/folder_';
                                    $uploadDir .= $evento->id;
                                    $uploadDir .= '/';
                                                               
                                    $files = array_diff(scandir($uploadDir), array('.', '..'));
                                    
                                    foreach ($files as $file) { ?>
                                    <img src="<?=$uploadDir . $file ?>" height="400" width="400"> <br/>
                                    <?php
                                    }
                                    

                                    if ($evento->inscreve == 1) {
                                    ?>
                                    <h6 class="card-title"><?=$evento->titulo ?></h6>
                                    <p class="card-text">
                                        <?php
                                        echo $evento->descricao . "<br/><br/>";
                                        if ($inscrito) {
                                            echo "<a class='btn btn-danger btn-sm' href='cancelar_inscricao_evento.php?id_evento=".$evento->id."&id_usuario=".$usuario_logado->id ."' ><i class='far fa-trash-alt'></i> Cancelar minha inscrição</a>";
                                        } else {
                                            echo "<a class='btn btn-primary btn-sm' href='save_inscricao_evento.php?id_evento=".$evento->id."&id_usuario=".$usuario_logado->id ."' ><i class='fa fa-check'></i> Me inscrever</a>";
                                        }
                                        ?>
                                    </p>
                                    <?php
                                    } else {
                                        ?>
                                        <h6 class="card-title"><?=$evento->titulo ?></h6>
                                        <p class="card-text">
                                        <?=$evento->descricao ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
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
        ?>

</body>

</html>
