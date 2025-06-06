<?php
//Questionário - Perguntas
$mod = 16;
// Verifica se o usuário está logado
require_once 'verifica_login.php';
require_once 'actions/ManterQuestEscala.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntas - INAS</title>

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
        var escalas = [];
        <?php
include_once('./actions/ManterQuestEscala.php');
// Carrega as escalas disponíveis
$manterEscala = new ManterQuestEscala();
$listaEscala = $manterEscala->listar();
foreach ($listaEscala as $obj) {
    ?>item = {id: "<?= $obj->id ?>", escala: "<?= $obj->nome ?>"};
                escalas.push(item);
    <?php
}
?>
        $(document).ready(function () {
            $('#perguntas').DataTable();
            carregaEscalas(0);
        });
        function alterar(id, titulo, pergunta, opcional,id_quest_escala) {
            $('#id_quest_pergunta').val(id);
            $('#titulo').val(titulo);
            $('#pergunta').val(pergunta);
            carregaEscalas(id_quest_escala);
            if (opcional == 1) {
                $('#opcional').prop('checked', true);
            } else {
                $('#opcional').prop('checked', false);
            }
            $('#form_quest_pergunta').collapse("show");
        }
        function excluir(id, titulo) {
            $('#delete').attr('href', 'del_quest_pergunta.php?id=' + id);
            $('#titulo_excluir').text(titulo);
            $('#confirm').modal({ show: true });
        }

        if (window.location.search.includes('msg=')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        function carregaEscalas(id_atual) {
                var html = '<option value="">Selecione uma escala</option>';
                for (var i = 0; i < escalas.length; i++) {
                    var option = escalas[i];
                    var selected = "";
                    if (id_atual > 0) {
                        if (option.id == id_atual) {
                            selected = "selected";
                        } else {
                            selected = "";
                        }
                    }
                    html += '<option value="' + option.id + '" ' + selected + '>' + option.escala + '</option>';
                }
                $('#escala').html(html);
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
                                <strong>Sucesso!</strong> Pergunta salva com sucesso.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                        } else if ($id_msg == 10) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Sucesso!</strong> A pergunta foi excluída.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                        } else {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erro!</strong> O Campo descrição deve receber um conteudo válido.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                        }
                    }
                    ?>
                    <?php include './form_quest_pergunta.php'; ?>
                    <div class="card mb-4 border-primary" style="max-width:1200px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <!-- <i class="fas fa-users fa-2x text-white"></i> -->
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Perguntas</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" title="Adicionar Pergunta" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_quest_pergunta" aria-expanded="false"S
                                    aria-controls="form_pergunta">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="perguntas" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;">ID</th>
                                        <th scope="col" style="text-align: center;">Título</th>
                                        <th scope="col" style="text-align: center;">Pergunta</th>
                                        <th scope="col" style="text-align: center;">Opcional</th>
                                        <th scope="col" style="text-align: center;">Escala</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_quest_pergunta.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                    <p>Deseja excluir <strong>"<span id="titulo_excluir"></span>"</strong>?</p>
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