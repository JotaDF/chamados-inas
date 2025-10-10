<?php
require_once('./verifica_login.php');
$mod = 3;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- CSS do Tema -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- CSS de Bibliotecas -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <!-- JS - Bibliotecas -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <!-- JS de DataTables -->
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <!-- JS de Utilidades -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tarefas').DataTable({
            });
        });
        function alterar(id, nome) {
            console.log(nome);
            $('#id').val(id);
            $('#nome').val(nome);
            $('#form_tipo_tarefa').collapse("show");
        }
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_tipo_tarefa.php?id=' + id);
            $('#nome_excluir').text(nome);
            $('#confirm').modal({ show: true });
        }
    </script>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_gerente.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <div class="container-fluid">
                    <div class="card mb-4  collapse hide border-primary" id="form_tipo_tarefa" style="max-width:800px">
                        <div class="card-header py-2 card-body bg-gradient-primary align-middle">
                            <span class="h6 m-0 font-weight text-white">Cadastro de Tipo de Tarefas</span>
                        </div>
                        <div class="card-body">
                            <form action="save_tipo_tarefa.php" method="POST">
                                <input type="hidden" id="id" name="id" />
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" name="nome" class="form-control form-control-sm" id="nome"
                                            placeholder="Nome" required>
                                    </div>
                                </div>
                                <div class="form-group row float-right">
                                    <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                                        data-target="#form_tipo_tarefa" class="btn btn-danger btn-sm"><i
                                            class="fa fa-minus-square"></i>
                                        Cancelar</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4 border-primary" style="max-width:1000px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-tasks fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Tipo de Tarefas
                                    <?= $txt_tipo ?></span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_tipo_tarefa" aria-expanded="false"
                                    aria-controls="form_tipo_tarefa">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tarefas" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_tipo_tarefa.php'; ?>
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