<?php
//Licitacao
$mod = 17;
require_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licitações</title>

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
        <!-- Quill Editor -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript" class="init">
        var quillOpcoes;
        var quillOpcoes;
        $(document).ready(function () {
            $('#licitacoes').DataTable({
                paging: true // Habilita a paginação
            });
            quillOpcoes = {
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

            quillObjeto = new Quill('#editor-objeto', { theme: 'snow' });

            document.getElementById('form_licitacao').addEventListener('submit', function () {
                const descHTML = quillObjeto.root.innerHTML;
                document.querySelector('input[name="objeto"]').value = descHTML;
            });

        });

        function alterar(id, modalidade, certame, ano) {
                $('#modalidade').val(modalidade);
                $('#certame').val(certame);
                $('#objeto').val(objeto);
                quillObjeto.root.innerHTML = $('#'+id+'_objeto').val();
                $('#ano').val(ano);
                $('#id').val(id);
                $('#form_licitacao').collapse("show");
        }
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_licitacao.php?id=' + id);
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
        <?php include './menu_compras.php'; ?>
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
                                <strong>Sucesso!</strong> Licitação salvo com sucesso.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                        } else if ($id_msg == 10) {
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Sucesso!</strong> A licitação foi excluído.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php include './form_licitacao.php'; ?>
                    <div class="card mb-4 border-primary dt-responsive" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary dt-responsive" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-shopping-basket fa-2x text-white"></i> 
                                </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Licitações</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" title="Adicionar Licitação" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_licitacao" aria-expanded="false"
                                    aria-controls="form_licitacao">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="licitacoes" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;">ID</th>
                                        <th scope="col" style="text-align: center;">Modalidade</th>
                                        <th scope="col" style="text-align: center;">Certame</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_licitacao.php'; ?>
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