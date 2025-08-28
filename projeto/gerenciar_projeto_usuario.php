<?php
$mod = 18;
require_once './verifica_login.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários do Projeto</title>
    <!-- CSS - Fontes e Ícones -->
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        var listaUsuario = [];
        var listaPerfilProjeto = [];
        <?php
                $id_projeto = $_GET['id'];
        ?>
        $(document).ready(function () {
            // Inicializa o DataTable
            $('#usuarios_projeto').DataTable({
                paging: false,
                searching: false
            });
        });
        function selectByText(select, text) {
            $(select).find('option:contains("' + text + '")').prop('selected', true);
        }
        function excluir(id_usuario, id_perfil_projeto, nome) {
            $('#delete').attr('href', 'remover_projeto_usuario.php?id_usuario=' + id_usuario + '&id_perfil=' + id_perfil_projeto + '&id_projeto=' + "<?= $id_projeto ?>");
            $('#excluir').text(nome);
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
        <?php include './menu_planejamento.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                require_once 'actions/ManterPerfilProjeto.php';
                require_once 'actions/ManterProjeto.php';

                $manterProjeto = new ManterProjeto();
                $manterPerfilProjeto = new ManterPerfilProjeto();
                $perfil = $manterPerfilProjeto->listar();
                $projeto = $manterProjeto->getProjetoPorId($id_projeto);
                $usuario = $manterProjeto->getUsuarioSemProjetoPorId($id_projeto);
                ?>
                <div class="container-fluid">
                    <div class="card mb-3 border-primary" style="max-width: 800px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">Cadastros de Usuários </div>
                                </div>
                                <div>
                                    <a href="projeto.php" class="btn btn-sm text-white border">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-users fa-3x text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="c1 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                                    <div class="mb-0"><?= $id_projeto ?></div>
                                </div>
                                <div class="c2 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Nome do Projeto:
                                    </div>
                                    <div class="mb-0"><?= $projeto->nome ?></div>
                                </div>
                                <div class="c4 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">STATUS</div>
                                    <div class="mb-0"><?= $projeto->status ?></div>
                                </div>
                            </div>
                            <br />
                            <p class=" ml-2 card-text">
                                <span class="mt-3 ml-2 h6 card-title">Usuário</span>
                            <form id="form_projeto_usuario" action="save_projeto_usuario.php" method="post">
                                <input type="hidden" id="id_projeto" name="id_projeto" value="<?= $id_projeto ?>" />
                                <div class="form-group row">
                                    <label for="usuario" class="col-sm-2 col-form-label">Usuário:</label>
                                    <div class="col-sm-10 mb-2">
                                        <select id="usuario" name="id_usuario" class="form-control form-control-sm"
                                            required>
                                            <option value="">Selecione o Usuário</option>
                                            <?php foreach ($usuario as $u) { ?>
                                                <option value="<?= $u->id ?>"><?= $u->nome ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label for="perfil_projeto" class="col-sm-2 col-form-label">Perfil do
                                        Projeto:</label>
                                    <div class="col-sm-10">
                                        <select id="id_perfil_projeto" name="id_perfil_projeto"
                                            class="form-control form-control-sm" required>
                                            <option value="">Selecione o perfil do projeto</option>
                                            <?php foreach ($perfil as $p) { ?>
                                                <option value="<?= $p->id ?>"><?= $p->nome ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-auto">
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fas fa-minus-square"></i> Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i> Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            </p>
                        </div>
                    </div>
                    <div class="card mb-4 border-primary" style="max-width:800px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-users fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Usuários</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="usuarios_projeto"
                                    class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Perfil</th>
                                            <th scope="col">Opções</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php include('get_projeto_usuario.php') ?>
                                    </tbody>
                                </table>
                            </div>
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
                    <p>Deseja excluir o Acesso de: <strong>"<span id="excluir"></span>"</strong>?</p>
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