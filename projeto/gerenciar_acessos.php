<?php
//Administração
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

        <title>Usuários - Gerenciador de acessos</title>

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
            function excluir(id, nome,id_usuario) {
                $('#delete').attr('href', 'remover_acesso.php?id_modulo=' + id + '&id_usuario=' + id_usuario);
                $('#nome_excluir').text(nome);
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
            <?php include './menu_admin.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterModulo.php');
                    include_once('actions/ManterUsuario.php');
                    include_once('actions/ManterPerfil.php');
                    include_once('actions/ManterSetor.php');

                    $manterModulo = new ManterModulo();
                    $manterPerfil = new ManterPerfil();
                    $manterUsuario = new ManterUsuario();
                    $manterSetor = new ManterSetor();

                    if (isset($_REQUEST['id'])) {
                        $id_usuario = $_REQUEST['id'];
                        $usuario    = $manterUsuario->getUsuarioPorId($id_usuario);
                        $modulosSemPermissao = $manterUsuario->getModulosParaAcessosUsuario($id_usuario);
                        $perfis = $manterPerfil->listar();
                        $editar = false;
                        
                        //if ($chamado->status == 1 || $chamado->status == 4) {
                            //$editar = true;
                        //}
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 800px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de acessos</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-lock fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Matrícula:</div>
                                            <div class="mb-0"><?= $usuario->matricula ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Setor</div>
                                            <div class="mb-0"><?= $manterSetor->getSetorPorId($usuario->setor)->sigla ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Nome</div>
                                            <div class="mb-0"><?= $usuario->nome ?></div>
                                        </div> 
                                    </div>
                                    <br/>
                                    <?php
                                        if($usuario_logado->perfil==1){
                                     ?>
                                    <p class=" ml-2 card-text">
                                    <span class="mt-3 ml-2 h6 card-title">Novo acesso</span>
                                    <form id="form_cadastro" action="conceder_acesso.php" method="post">
                                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$id_usuario ?>"/>
                                        <div class="form-group row">
                                            <label for="sigla" class="col-sm-2 col-form-label">Módulo:</label>
                                            <div class="col-sm-10">
                                            <select id="modulo" name="id_modulo" class="form-control form-control-sm" required>
                                                <option value="">Selecione</option>   
                                                <?php
                                                foreach ($modulosSemPermissao as $modulo) {
                                                ?> 
                                                    <option value="<?=$modulo->id ?>"><?=$modulo->nome ?></option> 
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="descricao" class="col-sm-2 col-form-label">Perfil:</label>
                                            <div class="col-sm-10">
                                            <select id="perfil" name="id_perfil" class="form-control form-control-sm" required>
                                                <option value="">Selecione</option>    
                                                <?php
                                                foreach ($perfis as $p) {
                                                ?> 
                                                    <option value="<?=$p->id ?>"><?=$p->perfil ?></option> 
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group row float-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Conceder</button>
                                        </div>
                                    </form>   

                                    </p>
                                    <?php
                                     }
                                    ?>
                                </div>
                            </div>
                            <!-- fim da exibição -->
                            <?php
                        }
                        ?>


                        <div class="card mb-4 border-primary" style="max-width:800px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fas fa-users fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Acessos concedidos</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">MÓDULO</th>
                                            <th scope="col">PERFIL</th>
                                            <th scope="col">REMOVER</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fila">
                                        <?php include './get_acesso.php'; ?>
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
