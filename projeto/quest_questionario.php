<?php
//Questionario
$mod = 16;
require_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html>

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

    <!-- Bootstrap CSS (repetido) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <!-- DataTables Bootstrap4 CSS (repetido) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <!-- DataTables Responsive Bootstrap4 CSS (repetido) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
        
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- jQuery 3.3.1 (NÃO SLIM, preferível para plugins) -->
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
    <!-- jQuery 3.3.1 SLIM (NÃO recomendado junto com o jQuery completo, pode causar conflito) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $('#questionario').DataTable({
                paging: true // Habilita a paginação
            });
            const quillOpcoes = {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
                    ],
                },
                theme: 'snow',
            };
            const quillDescricao = new Quill('#editor-descricao', quillOpcoes);
            document.getElementById('form_quest_questionario').addEventListener('submit', function () {
                // Coloca no campo hidden para enviar via POST
                var descHTML = quillDescricao.root.innerHTML;
                document.querySelector('input[name="descricao"]').value = descHTML;
            });
            function alterar(id, titulo, descricao) {
                $('#id_quest_questionario').val(id);
                $('#titulo').val(titulo);
                $('#descricao').val(descricao);
                quillDescricao.root.innerHTML = descricao;
                $('#form_quest_questionario').collapse("show");
            }
            function novo() {
                $('#id_quest_questionario').val("");
                $('#titulo').val("");
                $('#descricao').val("");
                quillDescricao.root.innerHTML = "";
                $('#form_quest_questionario').collapse("show");
            }
            window.alterar = alterar; // Torna a função global
            window.novo = novo; // Torna a função global
        });
        
        function excluir(id, titulo) {
            $('#delete').attr('href', 'del_quest_questionario.php?id=' + id);
            $('#nome_excluir').text(titulo);
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
                <div class="container float-left">
                    <?php
                    if ($_REQUEST['msg']) {
                        $id_msg = $_REQUEST['msg'];

                        if ($id_msg == 1) {
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sucesso!</strong> Questionário salvo com sucesso.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                        } else if ($id_msg == 10) {
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Sucesso!</strong> O questionário foi excluído.
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
                    <?php include './form_quest_questionario.php'; ?>
                    <div class="card mb-4 border-primary dt-responsive" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary dt-responsive" style="width:100%">
                            <!-- <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fas fa-users fa-2x text-white"></i>
                            </div> -->
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Quetionários</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" onclick="novo()" title="Adicionar Questionário" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_quest_questionario" aria-expanded="false"
                                    aria-controls="form_setor">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="questionario" class="table-sm table-striped table-bordered dt-responsive"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;">ID</th>
                                        <th scope="col" style="text-align: center;">Titulo</th>
                                        <th scope="col" style="text-align: center;">Descrição</th>
                                        <th scope="col" style="width:140px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_quest_questionario.php'; ?>
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