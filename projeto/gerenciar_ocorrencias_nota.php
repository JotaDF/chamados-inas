<?php
//Executor
$mod = 10;
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

        <title>Gerenciar ocorrências nota</title>

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
            function excluir(id_usuario, nome, id_prestador) {
                $('#delete').attr('href', 'save_executor_prestador.php?op=2&id_usuario=' + id_usuario +"&id_prestador="+id_prestador);
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
            <?php include './menu_execucao.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterPrestador.php');
                    include_once('actions/ManterTipoPrestador.php');
                    include_once('actions/ManterUsuario.php');
                    include_once('actions/ManterOcorrenciaNota.php');

                    $manterPrestador = new ManterPrestador();
                    $manterTipoPrestador = new ManterTipoPrestador();
                    $manterUsuario = new ManterUsuario();
                    $manterOcorrenciaNota = new OcorrenciaNota();

                    if (isset($_REQUEST['id'])) {
                        $id_prestador = $_REQUEST['id_prestador'];   
                        $id_nota = $_REQUEST['id'];
                        $tp = isset($_REQUEST['tp']) ? $_REQUEST['tp'] : 0;

                        $prestador    = $manterPrestador->getPrestadorPorId($id_prestador);
                        $editar = false;
                        
                        if ($tp == 1) {
                            $ocorrencias = $manterOcorrenciaNota->getOcorrenciasPorIdNotaPagamento($id_nota);
                        } else {
                            $ocorrencias = $manterOcorrenciaNota->getOcorrenciasPorIdNotaGlosa($id_nota);
                        }
                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 800px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row">
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de ocorrências em nota fiscal</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa fa-users fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">CNPJ:</div>
                                            <div class="mb-0"><?=$prestador->cnpj ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">PRESTADOR:</div>
                                            <div class="mb-0"><?=$prestador->nome_fantasia ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">TIPO:</div>
                                            <div class="mb-0"><?=$manterTipoPrestador->getTipoPrestadorPorId($prestador->tipo_prestador)->tipo ?></div>
                                        </div> 
                                        <div class="c4 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">PROCESSO SEI:</div>
                                            <div class="mb-0"><?= $prestador->processo_sei ?></div>
                                        </div>
                                    </div>
                                    <br/>
                                    <?php
                                        if($usuario_logado->perfil >= 2){
                                     ?>
                                    <p class=" ml-2 card-text">
                                    <span class="mt-3 ml-2 h6 card-title">Nova ocorrência</span>
                                    <form id="form_cadastro" action="save_ocorrencia_nota.php" method="post">
                                        <input type="hidden" id="id_prestador" name="id_prestador" value="<?=$prestador->id ?>"/>
                                        <input type="hidden" id="tp" name="tp" value="1<?=$tp ?>"/>
                                        <input type="hidden" id="op" name="op" value="1"/>
                                        <input type="hidden" id="id_nota" name="id_nota" value="<?=$id_nota ?>"/>
                                        <div class="form-group row">
                                            <label for="sigla" class="col-sm-2 col-form-label">Descrição:</label>
                                            <div class="col-sm-10">
                                            <textarea name="id_usuario" class="form-control" size="5" required>                    
                                            </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar </button>
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
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Ocorrências da nota</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">DESCRIÇÃO</th>
                                            <th scope="col">RESOLVIDO</th>
                                            <th scope="col">DATA</th>
                                            <th scope="col">OPÇÕES</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="fila">
                                        <?php include './get_ocorrencias_nota.php'; ?>
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
