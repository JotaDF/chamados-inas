<?php
//Chamados
$mod = 4;
require_once('./verifica_login.php');

$tipo = isset($_REQUEST['s']) ? $_REQUEST['s'] : 0;
$txt_tipo = "Pendentes";
$filtro = " WHERE status IN (0,1,4) ";
if ($tipo == 1) {
    $txt_tipo = "Concluídos";
    $filtro = " WHERE status IN (2,3) ";
}
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

    <title>Chamados - INAS</title>

    <!-- Custom fonts for this template-->
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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script type="text/javascript" class="init">
        var categorias = [];
        var usuarios = [];
        var quillEditor;
        <?php
        include_once('actions/ManterCategoria.php');
        $mCategoria = new ManterCategoria();

        include_once('actions/ManterUsuario.php');
        $manterUsuario = new ManterUsuario();

        if ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 9) {
            $listaCategorias = $mCategoria->listar();
            foreach ($listaCategorias as $obj) {
                ?>item = { id: "<?= $obj->id ?>", nome: "<?= $obj->nome ?>" };
                categorias.push(item);
                <?php
            }
            $listaUsuarios = $manterUsuario->listar();
            foreach ($listaUsuarios as $obj) {
                ?>item2 = { id: "<?= $obj->id ?>", nome: "<?= $obj->nome ?>" };
                usuarios.push(item2);
                <?php
            }

        } else {
            header('Location: meus_chamados.php');
        }



        ?>

        $(document).ready(function () {
            $('#chamados').DataTable();
            carregaCategorias(0);
            carregaUsuarios(0);

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

            // Instanciar o Quill para o editor de TAP
            quillEditor = new Quill('#editor', quillOpcoes);
            document.getElementById('form_chamado').addEventListener('submit', function () {
                const quillEditorHTML = quillEditor.root.innerHTML;
                document.querySelector('input[name="descricao"]').value = quillEditorHTML;
            });
        });
        function cancelar(id, usuario, descricao, id_usuario_logado) {
            $('#acao').attr('href', 'cancelar_chamado.php?id=' + id + '&id_usuario=' + id_usuario_logado);
            $('#acao_texto').text("Confimação de cancelamento do chamado:");
            $('#acao_usuario').text(usuario);
            $('#acao_descricao').html(descricao);
            $('#confirm').modal({ show: true });
        }
        function reabrir(id, usuario, descricao, categoria, id_usuario_logado) {
            $('#acao').attr('href', 'reabrir_chamado.php?id=' + id + '&id_usuario=' + id_usuario_logado);
            $('#acao_texto').text("Confimação de reabertura do chamado:");
            $('#acao_usuario').text(usuario);
            $('#acao_descricao').html(descricao);
            $('#confirm').modal({ show: true });
        }


        function atender(id, usuario, descricao, categoria) {
            $('#atender_id').val(id);
            $('#atender_usuario').text(usuario);
            $('#atender_descricao').html(descricao);
            carregaCategorias(categoria);
            $('#atender').modal({ show: true });
        }
        function alterar(id, nome, descricao) {
            $('#id').val(id);
            $('#nome').val(nome);
            $('#descricao').val(descricao);
            $('#form_chamado').collapse("show");
            $('#btn_cadastrar').hide();
        }

        function selectByText(select, text) {
            $(select).find('option:contains("' + text + '")').prop('selected', true);
        }
        function carregaCategorias(id_atual) {
            var html = '<option value="">Selecione </option>';
            for (var i = 0; i < categorias.length; i++) {
                var option = categorias[i];
                var selected = "";
                if (id_atual > 0) {
                    if (option.id == id_atual) {
                        selected = "selected";
                    } else {
                        selected = "";
                    }
                }
                html += '<option value="' + option.id + '" ' + selected + '>' + option.nome + '</option>';
            }
            $('#categoria').html(html);
        }
        function carregaUsuarios(id_atual) {
            var html = '<option value="">Selecione </option>';
            for (var i = 0; i < usuarios.length; i++) {
                var option = usuarios[i];
                var selected = "";
                if (id_atual > 0) {
                    if (option.id == id_atual) {
                        selected = "selected";
                    } else {
                        selected = "";
                    }
                }
                html += '<option value="' + option.id + '" ' + selected + '>' + option.nome + '</option>';
            }
            $('#usuario').html(html);
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
        <?php include './menu_chamados.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>

                <div class="container-fluid">

                    <?php include './form_chamado.php'; ?>
                    <!-- Project Card Example -->
                    <div class="card mb-4 border-primary" style="max-width:1000px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-id-card fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Chamados
                                    <?= $txt_tipo ?></span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_chamado" aria-expanded="false"
                                    aria-controls="form_chamado">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="chamados" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Setor</th>
                                        <th scope="col">Usuário</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Aberto em</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_chamado.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        Legenda:<br />
                        <img src="img/chamado_aberto.svg" title="Chamado Aberto" width="30" /> Aberto
                        <img src="img/chamado_atendimento.svg" title="Chamado Em atendimento" width="30" /> Em
                        atendimento
                        <img src="img/chamado_concluido.svg" title="Chamado Concluído" width="30" /> Concluído
                        <img src="img/chamado_cancelado.svg" title="Chamado Cancelado" width="30" /> Cancelado
                        <img src="img/chamado_reaberto.svg" title="Chamado Reaberto" width="30" /> Reaberto

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
                    <p><span id="acao_texto"></span><br />
                        <span id="acao_usuario"></span><br />
                        <strong><span id="acao_descricao"></span></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="#" type="button" class="btn btn-danger" id="acao">Confirmar</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Desistir</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal atendimento -->
    <div class="modal fade" id="atender" tabindex="-1" role="dialog" aria-labelledby="TituloAtendimento"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="form_atendimento" action="atender_chamado.php" method="post">
                <input type="hidden" name="id" id="atender_id" />
                <input type="hidden" name="atendente" value="<?= $usuario_logado->id ?>" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TituloAtendimento">Atender chamado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <span id="atender_usuario"></span><br />
                            <strong><span id="atender_descricao"></span></strong>
                        </p>
                        <div class="form-group row">
                            <label for="categoria" class="col-sm-2 col-form-label">Categoria:</label>
                            <div class="col-sm-10">
                                <select id="categoria" name="categoria" class="form-control form-control-sm" required>
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_atender">Atender</button>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>