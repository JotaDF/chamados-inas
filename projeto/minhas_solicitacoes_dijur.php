<?php
//Chamados
$mod = 26;
require_once('./verifica_login.php');
$filtro = " WHERE id_usuario = " . $usuario_logado->id;
$setor = "dijur";
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

    <title>Minhas Solicitacões - INAS</title>

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
  
        $(document).ready(function () {
            $('#chamados').DataTable();
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
            quillEditorMotivo = new Quill('#editor_motivo', quillOpcoes);
            document.getElementById('form_chamado').addEventListener('submit', function () {
                const quillEditorHTML = quillEditor.root.innerHTML;
                document.querySelector('input[name="descricao"]').value = quillEditorHTML;
            });
            document.getElementById('form_acao').addEventListener('submit', function () {
                const quillEditorHTMLMotivo = quillEditorMotivo.root.innerHTML;
                document.querySelector('input[name="motivo_reabertura"]').value = quillEditorHTMLMotivo;
            });
        });
        function cancelar(id, usuario, descricao, usuario_logado) {
            $('#container_reabertura').hide();

            $('#form_acao').attr(
                'action',
                'cancelar_solicitacao.php?id_usuario=' + usuario_logado
            );

            $('#id').val(id);
            $('#id_chamado_reabertura').val('');

            $('#acao_texto').text('Confirmação de cancelamento do chamado:');
            $('#acao_usuario').text(usuario);
            $('#acao_descricao').html(descricao);

            $('#confirm').modal('show');
        }

        function reabrir(id, usuario, descricao, status, categoria, usuario_logado) {
            $('#container_reabertura').show();

            $('#form_acao').attr(
                'action',
                'reabrir_chamado.php'
            );

            $('#id_chamado_reabertura').val(id);
            $('#id_chamado').val('');

            $('#acao_texto').text('Confirmação de reabertura do chamado:');
            $('#acao_motivo').text('Motivo de reabertura do chamado:');
            $('#acao_usuario').text(usuario);
            $('#acao_descricao').html(descricao);

            $('#confirm').modal('show');
        }

        function mostraAnexos(id_solicitacao, pasta) {

            $('#lista_arquivos').html(
                '<p class="text-center text-muted">Carregando arquivos...</p>'
            );

            $.ajax({
                url: 'listar_arquivos_solicitacao.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    pasta: pasta
                },
                success: function (arquivos) {

                    $('#lista_arquivos').html(
                        montarListaArquivos(id_solicitacao, pasta, arquivos)
                    );

                    $('#modalArquivos').modal('show');
                }
            });
        }
        function montarListaArquivos(id_solicitacao, pasta, itens) {

            let html = '';

            itens.forEach(function(item) {

                // Se for um diretório
                if (item.tipo === 'diretorio') {
                    return;
                }

                // Se for um arquivo
                const link = `${pasta}/${item.caminho.replace(/^.*?\//, '')}`;

                html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center mb-2">

                        <div class="d-flex align-items-center">
                            <i class="fa fa-file mr-2"></i>
                            <span>${item.nome}</span>
                        </div>

                        <div>

                            <a href="${link}"
                            class="btn btn-primary btn-sm mr-1"
                            title="Baixar arquivo"
                            download>
                                <i class="fa fa-download"></i>
                            </a>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                title="Excluir arquivo"
                                onclick="excluirArquivo('${id_solicitacao}','${pasta}','${item.caminho}')">

                                <i class="fa fa-times"></i>

                            </button>

                        </div>

                    </div>
                `;
            });

            return html;
        }
        function montarListaArquivos2(id_solicitacao, pasta, arquivos) {

            let html = '';

            arquivos.forEach(function (arquivo) {

                const link = `${pasta}/${arquivo}`;

                html += `
            <div class="list-group-item d-flex justify-content-between align-items-center mb-2">

                <div class="d-flex align-items-center">
                    <i class="fa fa-file mr-2"></i>
                    <span>${arquivo}</span>
                </div>

                <div>

                    <a href="${link}"
                       class="btn btn-primary btn-sm mr-1"
                       title="Baixar arquivo"
                       download>
                        <i class="fa fa-download"></i>
                    </a>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        title="Excluir arquivo"
                        onclick="excluirArquivo('${id_solicitacao}','${pasta}', '${arquivo}')">

                        <i class="fa fa-times"></i>

                    </button>

                </div>

            </div>
        `;
            });

            return html;
        }

        function selectByText(select, text) {
            $(select).find('option:contains("' + text + '")').prop('selected', true);
        }
        /*
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
*/
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
        <?php include './menu_solicitacoes_dijur.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>

                <div class="container-fluid">

                    <!-- Project Card Example -->
                    <div class="card mb-4 border-primary" style="max-width:1200px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-id-card fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Minhas Solicitações
                                    <?= $txt_tipo ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="chamados" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Processo</th>
                                        <th scope="col">Setor</th>
                                        <th scope="col">Solicitante</th>
                                        <th scope="col">Descrição</th>
                                        <?php if ($setor != "dijur") { ?>
                                            <th scope="col">Responsável</th>
                                        <?php } ?>
                                        <th scope="col">Aberto Em</th>
                                        <th scope="col">Anexos</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" style="width:100px;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include './get_minhas_solicitacoes.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        Legenda:<br /><br />
                        <div class="d-flex">
                            <div class="mx-4">
                                <i class="fa fa-inbox fa-2x text-primary"></i>
                                <div class="mt-2">Aberta</div>
                            </div>
                            <div class="mx-4">
                                <i class="fa fa-hourglass-start fa-2x text-warning"></i>
                                <div class="mt-2">Em atendimento</div>
                            </div>

                            <div class="mx-4">
                                <i class="fa fa-check-circle fa-2x text-success"></i>
                                <div class="mt-2">Concluída</div>
                            </div>

                            <div class="mx-4">
                                <i class="fa fa-ban fa-2x text-danger"></i>
                                <div class="mt-2">Cancelada</div>
                            </div>
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
        <div class="modal-dialog modal-lm">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form_acao" method="POST">

                    <div class="modal-body">

                        <p>
                            <span id="acao_texto"></span>
                            <br><br>

                            <span id="acao_usuario"></span>
                            <br><br>

                            <strong>"<span id="acao_descricao"></span>"</strong>
                        </p>

                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="id_chamado_reabertura" name="id_chamado_reabertura">

                        <input type="hidden" id="usuario_logado_chamado" name="usuario_logado_chamado"
                            value="<?= $usuario_logado->id ?>">

                        <div id="container_reabertura">

                            <p>
                                <span id="acao_motivo"></span>
                            </p>

                            <div style="width:100%; height:95px;" id="editor_motivo"></div>

                            <input type="hidden" id="motivo_reabertura" name="motivo_reabertura">

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">
                            Confirmar
                        </button>

                        <button type="button" data-dismiss="modal" class="btn btn-secondary">
                            Desistir
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- Modal atendimento -->
    <div class="modal fade" id="atender" tabindex="-1" role="dialog" aria-labelledby="TituloAtendimento"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="form_atendimento" action="atender_solicitacao.php" method="post">
                <input type="hidden" name="id" id="atender_id" />
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
                            <strong>"<span id="atender_descricao"></span>"</strong>
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
    <!-- Modal Anexos -->
    <div class="modal fade" id="modalArquivos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Arquivos da Solicitação
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div id="lista_arquivos">

                        <!-- Arquivos serão adicionados via JavaScript -->
                        <a href="arquivo1.pdf" class="list-group-item list-group-item-action">
                            <i class="fa fa-file-pdf text-danger"></i>
                            contrato.pdf
                        </a>

                        <a href="arquivo2.pdf" class="list-group-item list-group-item-action">
                            <i class="fa fa-file-image text-primary"></i>
                            foto.png
                        </a>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Fechar
                    </button>

                </div>

            </div>

        </div>
    </div>
</body>

</html>