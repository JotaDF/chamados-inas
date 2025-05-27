<?php
//Questionário
$mod = 16;
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

        <title>Usuários - Gerenciar perguntas da categoria do questionário</title>

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
            function excluir(id_pergunta, nome, id_categoria, id_questionario) {
                $('#delete').attr('href', 'save_pergunta_categoria_questionario.php?op=2&id_pergunta=' + id_pergunta +"&id_categoria="+id_categoria +"&id_questionario="+id_questionario);
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
            <?php include './menu_questionario.php'; ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php include './top_bar.php'; ?>
                    <?php
                    include_once('actions/ManterQuestQuestionario.php');
                    include_once('actions/ManterQuestCategoriaPergunta.php');

                    $manterQuestionario = new ManterQuestQuestionario();
                    $manterCategoriaQuetionario = new ManterQuestCategoriaPergunta();
                    $categorias    = array();
                    if (isset($_REQUEST['id_categoria']) && isset($_REQUEST['id_questionario'])) {
                        $id_categoria = $_REQUEST['id_categoria'];  
                        $id_questionario = $_REQUEST['id_questionario'];                      
                        $questionario    = $manterQuestionario->getQuestionarioPorId($id_questionario);
                        $categoria       = $manterCategoriaQuetionario->getCategoriaPorId($id_categoria);
                        $perguntas       = $manterCategoriaQuetionario->getPeguntasPorCategoria($id_categoria);
                        $perguntas_nao   = $manterCategoriaQuetionario->getPeguntasNaoVinculadasCategoria($id_categoria);
                        $editar = false;

                        ?>
                        <div class="container-fluid">
                            <!-- Exibe dados da  tarefa -->
                            <div class="card mb-3 border-primary" style="max-width: 1000px;">
                                <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                    <div class="row"> 
                                        <div class="col c2 ml-2">
                                            <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de perguntas da categoria</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-tags fa-3x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <span class="mt-3 ml-2 h6 card-title">Questionário</span>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Título:</div>
                                            <div class="mb-0"><?=$questionario->titulo ?></div>
                                        </div> 
                                        <div class="c3 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Descrição:</div>
                                            <div class="mb-0"><?=$questionario->descricao ?></div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <span class="mt-3 ml-2 h6 card-title">Categoria</span>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Nome:</div>
                                            <div class="mb-0"><?=$categoria->nome ?></div>
                                        </div> 
                                    </div>
                                    <br/>
                                    <p class=" ml-2 card-text">
                                    <span class="mt-3 ml-2 h6 card-title">Pergunta</span>
                                    <form id="form_cadastro" action="save_pergunta_categoria_questionario.php" method="post">
                                        <input type="hidden" id="id_questionario" name="id_questionario" value="<?=$questionario->id ?>"/>
                                        <input type="hidden" id="id_categoria" name="id_categoria" value="<?=$categoria->id ?>"/>
                                        <input type="hidden" id="op" name="op" value="1"/>
                                        <div class="form-group row">
                                            <label for="sigla" class="col-sm-2 col-form-label">Pergunta:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control form-control-sm" id="id_pergunta" name="id_pergunta">
                                                    <option value="">Selecione uma pergunta</option>
                                                    <?php
                                                    foreach ($perguntas_nao as $obj) {
                                                        echo "<option value='" . $obj->id . "'>" . $obj->titulo . " - " . $obj->pergunta . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Adicionar</button>
                                        </div>
                                    </form>   

                                    </p>
                                </div>
                            </div>
                            <!-- fim da exibição -->
                            <?php
                        }
                        ?>

                        <div class="card mb-4 border-primary" style="max-width:1000px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-tags fa-2x text-white"></i> 
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Perguntas da categoria</span>
                                </div>
                            </div>                            

                            <div class="card-body">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">PERGUNTA</th>
                                            <th scope="col" style="width: 130px;">REMOVER</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fila">
                                        <?php include './get_perguntas_categoria.php'; ?>
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
