<?php
//Oficios
$mod = 23;
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

        <title>Gerenciar Acessos a Gestão de Ofícios</title>

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
            function excluir(id, nome) {
                $('#delete').attr('href', 'save_acesso_oficio.php?op=2&id=' + id);
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
            <?php 

            include 'menu_oficio.php';
            ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    require_once('./actions/ManterAcessoOficio.php');
                    require_once('./actions/ManterSetor.php');

                    $db_setor = new ManterSetor();
                    $setor = $db_setor->getSetorPorId($usuario_logado->setor);
                    $array_setor = explode("/", $setor->sigla);
                    $origem  = "";
                    if (count($array_setor) > 1) {
                        if($array_setor[1] == "DIPLAS" or $array_setor[1] == "DIAD" or $array_setor[1] == "DIJUR" or $array_setor[1] == "DIFIN" ){
                            $origem = trim($array_setor[0] . "/" . $array_setor[1]);
                        } else {
                            $origem = trim($array_setor[0]);
                        }
                    } else {
                        $origem = trim($array_setor[0]);
                    }
                    
                    if ( $origem != "" ) {

                        $db_acesso_oficio = new ManterAcessoOficio();
                        $usuariosSemAcessoOficio = $db_acesso_oficio->getUsuariosSemAcessoOficio($origem);
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 800px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de acesso aos ofícios da <?= $origem ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa fa-users fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                        if($usuario_logado->perfil <= 2){
                                     ?>
                                    <p class=" ml-2 card-text">
                                    <span class="mt-3 ml-2 h6 card-title">Novo acesso</span>
                                    <form id="form_cadastro" action="save_acesso_oficio.php" method="post">
                                        <input type="hidden" id="op" name="op" value="1"/>
                                        <input type="hidden" id="setor" name="setor" value="<?=$origem ?>"/>
                                        <div class="form-group row">
                                            <label for="id_usuario" class="col-sm-2 col-form-label">Usuario:</label>
                                            <div class="col-sm-10">
                                            <select id="id_usuario" name="id_usuario" class="form-control form-control-sm" required>
                                                <option value="">Selecione</option>   
                                                <?php
                                                foreach ($usuariosSemAcessoOficio as $usuario) {
                                                    if(!$db_acesso_oficio->possuiAcessoModuloOficio($usuario->id)){                                                    
                                                ?> 
                                                    <option value="<?=$usuario->id ?>"><?=$usuario->nome ?></option> 
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group row"> 
                                            <div class="col-sm-offset-2 col-sm-10">
                                            <div class="checkbox">
                                                <label class="text-danger"><input type="checkbox" id="editor" name="editor" value="1"><b> Pode editar</b></label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Incluir </button>
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
                                            <th scope="col">MATRÍCULA</th>
                                            <th scope="col">NOME</th>
                                            <th scope="col">SETOR</th>
                                            <th scope="col">EDITOR</th>
                                            <th scope="col">ATIVO</th>
                                            <th scope="col">REMOVER</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="usuarios">
                                        <?php include './get_acessos_oficio.php'; ?>
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
