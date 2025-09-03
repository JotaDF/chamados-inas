<?php
$mod = 18;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Perfil de Projeto</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        $(document).ready(function () {
            $('#perfils').DataTable({
                 searching: false,
                 paging: false
            });
        });

        function alterar(id, nome) {
            $('#id').val(id);
            $('#nome').val(nome);
            $('#form_perfil').collapse('show');
            $('#nome').focus();
        }
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_perfil_projeto.php' + '?id=' + id);
            $('#excluir').text(nome);
            $('#confirm').modal('show');
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
        <?php include './menu_planejamento.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'top_bar.php'; ?>
                <?php 
                require_once('actions/ManterPerfilProjeto.php');
                $manterPerfilProjeto = new ManterPerfilProjeto();
                $perfil              = $manterPerfilProjeto->listar();
                ?>
                <div class="container-fluid">
                    <div class="card mb-4 collapse hide border-primary" id="form_perfil" style="max-width:800px">
                        <div class="card-header py-2 card-body bg-gradient-primary align-middle">
                            <span class="h6 m-0 font-weight text-white">Cadastro de Perfils</span>
                        </div>
                        <div class="card-body">
                            <form action="save_perfil_projeto.php" method="POST">
                                <input type="hidden" name="id_perfil_projeto" id="id">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" name="nome" class="form-control form-control-sm" id="nome"
                                            placeholder="Nome" required>
                                    </div>
                                </div>
                                <div class="form-group row float-right">
                                    <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                                        data-target="#form_perfil" class="btn btn-danger btn-sm"><i
                                            class="fa fa-minus-square"></i>
                                        Cancelar</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4 border-primary" style="max-width:800px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                 <i class="fa fa-users fa-2x text-white"></i> 
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Perfils</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" onclick="novo()" class="btn btn-outline-light btn-sm"
                                    type="button" data-toggle="collapse" data-target="#form_perfil"
                                    aria-expanded="false" aria-controls="form_perfil">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="perfils"
                                    class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center;">ID</th>
                                            <th scope="col" style="text-align: center;">Nome</th>
                                            <th scope="col" style="width:50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_perfil_projeto.php'); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'rodape.php'; ?>
        </div>
    </div>

    <!-- Scroll-to-top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal de Confirmação -->
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
                    <p>Deseja excluir o perfil_projeto <strong>"<span id="excluir"></span>"</strong>?</p>
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