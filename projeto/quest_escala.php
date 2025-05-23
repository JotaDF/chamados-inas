<?php
$mod = 16;
require_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escala - INAS</title>
  
    <!-- Ícone -->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- Fontes e ícones -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Estilos do template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap 4 + DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <!-- jQuery (usar apenas 1 vez, versão completa!) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap (bundle contém Popper + collapse) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <!-- Plugins adicionais -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#escalas').DataTable();
        });
          function alterar(id, nome, descricao, parametro) {
            $('#id_quest_escala').val(id);
            $('#nome').val(nome);
            $('#descricao').val(descricao);
            $('#parametro').val(parametro);
            $('#form_quest_escala').collapse("show");
        }

        function excluir(id, nome) {
            console.log(id);
            $('#delete').attr('href', 'del_quest_escala.php?id=' + id);
            $('#nome_excluir').text(nome);
            $('#confirm').modal({ show: true });
        }
        if (window.location.search.includes('msg=')) {
            window.history.replaceState({}, document.title, window.location.pathname);
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
                <div class="container float-left ">
                    <?php
                    if ($_REQUEST['msg']) {
                        $id_msg = $_REQUEST['msg'];

                        if ($id_msg == 1) {
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sucesso!</strong> Escala salva com sucesso.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                        } else if ($id_msg = 2) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erro!</strong> O Campo descrição deve receber um conteudo válido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                        } else if ($id_msg = 10) {
                            ?>
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Sucesso!</strong> O Campo descrição deve receber um conteudo válido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <?php
                        }
                    }
                    ?>
                    <?php include './form_quest_escala.php'; ?>
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fas fa-users fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Escalas</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" title="Adicionar Escala" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_quest_escala" aria-expanded="false"
                                    aria-controls="form_setor">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="escalas" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;">ID</th>
                                        <th scope="col" style="text-align: center;">Nome</th>
                                        <th scope="col" style="text-align: center;">Descrição</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_quest_escala.php'; ?>
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