<?php
$mod = 16;
require_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário - INAS</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#questionario').DataTable({
                paging: false // Habilita a paginação
            });
        });
        
        function alterar(id, inicio, termino) {
            $('#inicio').val(inicio);
            $('#id').val(id);
            $('#termino').val(termino);
        }
    </script>
    <style>
        body {
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
                require_once 'actions/ManterQuestAplicacao.php';
                include_once('actions/ManterQuestQuestionario.php');
                $manterQuestQuestionario = new ManterQuestQuestionario();
                $manterQuestAplicacao = new ManterQuestAplicacao();
                if (isset($_REQUEST['id'])) {
                    $id_questionario = $_REQUEST['id'];
                    $questionario = $manterQuestQuestionario->getQuestionarioPorId($id_questionario);
                    $aplicacao = $manterQuestAplicacao->listar();
                }

                ?>
                <div class="container-fluid">
                    <!-- Exibe dados da  tarefa -->
                    <div class="card mb-3 border-primary" style="max-width: 1000px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">Gerenciamento de aplicação dos
                                        questionarios</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-flag fa-3x text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="c1 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                                    <div class="mb-0"><?= $questionario->id ?></div>
                                </div>
                                <div class="c2 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Título:</div>
                                    <div class="mb-0"><?= $questionario->titulo ?></div>
                                </div>
                                <div class="c3 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Descrição:</div>
                                    <div class="mb-0"><?= $questionario->descricao ?></div>
                                </div>
                            </div>
                            <br />
                            <p class=" ml-2 card-text">
                                <span class="mt-3 ml-2 h6 card-title">Aplicação</span>
                            <form id="form_cadastro" action="save_quest_aplicacao.php" method="post">
                                <input type="hidden" id="id_quest_questionario" name="id_quest_questionario"
                                    value="<?= $questionario->id ?>" />
                                <input type="hidden" id="id" name="id" value="" />
                                <div class="form-group row">
                                    <label for="sigla" class="col-sm-2 col-form-label">Inicio:</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="inicio" name="inicio"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sigla" class="col-sm-2 col-form-label">Término:</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="termino" name="termino"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="form-group row float-right">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i>
                                        Salvar </button>
                                </div>
                            </form>

                            </p>
                        </div>
                    </div>
                    <!-- fim da exibição -->
                    <?php

                    ?>


                    <div class="card mb-4 border-primary" style="max-width:1000px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-flag fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Aplicações do
                                    questionário</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">INICIO</th>
                                        <th scope="col">TÉRMINO</th>
                                        <th scope="col" style="width: 130px;">PUBLICADO</th>
                                        <th scope="col" style="width: 130px;">OPÇÕES</th>
                                    </tr>
                                </thead>
                                <tbody id="fila">
                                    <?php include './get_quest_aplicacao.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php'; ?>
        </div>
    </div>
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