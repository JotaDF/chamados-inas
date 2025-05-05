<?php
//Chamados
$mod = 4;
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

        <title>Chamado - Gerenciador de interações</title>

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
            });
            function interacao() {
                $('#nova').modal({show: true});  
            }
            function reabrir(id,usuario,descricao,id_usuario) { 
                $('#acao').attr('href', 'reabrir_chamado.php?id=' + id + '&id_usuario=' + id_usuario);
                $('#acao_texto').text("Confimação de reabertura do chamado:");
                $('#acao_usuario').text(usuario);
                $('#acao_descricao').text(descricao);
                $('#confirm').modal({show: true});              
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
            <?php include './menu_chamados.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterChamado.php');
                    include_once('actions/ManterUsuario.php');
                    include_once('actions/ManterCategoria.php');

                    $manterChamado = new ManterChamado();
                    $manterCategoria = new ManterCategoria();
                    $manterUsuario = new ManterUsuario();

                    if (isset($_REQUEST['id'])) {
                        $id_chamado = $_REQUEST['id'];
                        $chamado    = $manterChamado->getChamadoPorId($id_chamado);
                        $usuario    = $manterUsuario->getUsuarioPorId($chamado->usuario);
                        $categoria  = $manterCategoria->getCategoriaPorId($chamado->categoria);
                        $editar = false;
                        
                        if ($chamado->status == 1 || $chamado->status == 4) {
                            $editar = true;
                        }
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 800px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h6 text-xs text-white font-weight-bold text-uppercase mb-1">Chamado</div>
                                            <div class="h5 mb-0 text-white font-weight-bold">[<small><?=$chamado->id ?></small>] <?= $categoria->nome ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-tasks fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aberto em:</div>
                                            <div class="mb-0"><?= date('d/m/Y H:i', strtotime($chamado->data_abertura)) ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <?php
                                            $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
                                            switch ($chamado->status) {
                                                case 0:
                                                    $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
                                                    break;
                                                case 1:
                                                    $txt_status = '<img src="img/chamado_atendimento.svg" title="Em atendimento" width="40" />';
                                                    break;
                                                case 2:
                                                    $txt_status = '<img src="img/chamado_concluido.svg" title="Concluído" width="40" />';
                                                    break;
                                                case 3:
                                                    $txt_status = '<img src="img/chamado_cancelado.svg" title="Cancelado" width="40" />';
                                                    break;
                                                case 4:
                                                    $txt_status = '<img src="img/chamado_reaberto.svg" title="Reaberto" width="40" />';
                                                    break;
                                            }
                                            ?>
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Status</div>
                                            <div class="mb-0"><?=$txt_status ?></div>
                                        </div> 
                                    </div>
                                    <h6 class="mt-3 ml-2 card-title">Aberto por:</h6>
                                    <p class=" ml-2 card-text"><?= $usuario->nome ?></p>
                                    <h6 class="mt-3 ml-2 card-title">Descrição da solicitação</h6>
                                    <p class=" ml-2 card-text"><?= $chamado->descricao ?></p>
                                
                                <br/>
                                <div class="row">
                                        <div class="c1 ml-4" style="width: 80%">
                                    <?php
                                        if($usuario_logado->id==$chamado->usuario || $usuario_logado->perfil<=2 || $usuario_logado->perfil==9){

                                            if($chamado->status == 2){
                                                ?>
                                                <button class="btn btn-warning btn-sm" type="button" onclick="reabrir('<?=$chamado->id ?>','<?=$usuario->nome  ?>','<?=$chamado->descricao ?>','<?=$usuario_logado->id ?>')">
                                                      <i class="fa fa-history text-white" aria-hidden="true"></i>  Reabrir chamado
                                                </button>
                                                <?php
                                            } else if($chamado->status == 1 || $chamado->status == 4){
                                            ?>                                     
                                                <button class="btn btn-success btn-sm" type="button" onclick="interacao()">
                                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>  Nova interação
                                                </button> 
                                            <?php 
                                            }
                                    ?>
                                    </div>
                                    <?php
                                     }
                                    ?>
                                    </div>
                                    </div>
                            </div>
                            <!-- fim da exibição -->
                            <?php
                        }
                        ?>

                        <!-- ETAPAS -->
                        <?php include './get_interacao.php'; ?>
                        <!-- FIM ETAPAS -->
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

        <!-- Modal -->
        <div class="modal fade" id="nova" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="form_cadastro" action="registrar_interacao.php" method="post">
            <input type="hidden" id="id_chamado" name="id_chamado" value="<?=$chamado->id ?>"/>                        
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>"/>
            <div class="modal-content" style="width: 600px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloModalCentralizado">Nova interação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="texto" name="texto" class="form-control form-control-sm" required></textarea>      
                </div>
                <div class="modal-footer">
                <?php
                    if($usuario_logado->id!=$chamado->usuario && ($usuario_logado->perfil<=2 || $usuario_logado->perfil==9)){
                    ?>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="finalizar" id="finalizar">
                        <label class="form-check-label" for="finalizar">Finalizar chamado</label>
                    </div>
                    <?php
                    }
                    ?>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                </div>
            </div>
            </form>
        </div>
        </div>
        <!-- Modal reabrir -->
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
                        <p><span id="acao_texto"></span><br/>
                        <span id="acao_usuario"></span><br/>
                    <strong>"<span id="acao_descricao"></span>"</strong></p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger" id="acao">Confirmar</a>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Desistir</button>
                    </div>
                </div>

            </div>
        </div>
    </body>

</html>
