<?php
$mod = 26;
require_once('./verifica_login.php');
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

    <title>Solicitações - Gerenciador de interações</title>

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
        var quillEditor;
        $(document).ready(function () {
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
            document.getElementById('nova').addEventListener('submit', function () {
                const quillEditorHTML = quillEditor.root.innerHTML;
                document.querySelector('input[name="texto"]').value = quillEditorHTML;
            });
            document.getElementById('form_reabertura').addEventListener('submit', function (e) {

                const id_perfil = <?= $usuario_logado->perfil ?>;
                let atendente = id_perfil <= 2 || id_perfil == 9;
                const quillEditorHTMLMotivo = quillEditorMotivo.root.innerHTML;
                const textoLimpo = quillEditorMotivo.getText().trim();
                if (textoLimpo === '' && atendente === false) {

                    e.preventDefault();

                    $('#editor_motivo .ql-container').addClass('campo-obrigatorio');
                    $('#erro_motivo').show();

                    quillEditorMotivo.focus();

                    return false;
                }

                document.getElementById('motivo_reabertura').value =
                    quillEditorHTMLMotivo;
            });
            quillEditorMotivo.on('text-change', function () {

                const texto = quillEditorMotivo.getText().trim();

                if (texto !== '') {
                    $('#editor_motivo .ql-container').removeClass('campo-obrigatorio');
                    $('#erro_motivo').hide();
                }
            });
        });

        function excluirArquivo(id_solicitacao, pasta, arquivo) {

            if (!confirm(`Deseja realmente excluir o arquivo "${arquivo}"?`)) {
                return;
            }

            $.ajax({
                url: 'exclui_arquivo_solicitacao.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    pasta: pasta,
                    arquivo: arquivo
                },
                success: function (retorno) {

                    if (retorno.sucesso) {

                        $('#mensagem_exclusao_arquivo').text(
                            "Arquivo excluído com sucesso!"
                        );

                        mostraAnexos(id_solicitacao, pasta);
                    }
                }
            });
        }

        function interacao() {
            $('#nova').modal({ show: true });
        }

        function cancelar(id, usuario, descricao, id_usuario_logado) {
            $('#acao').attr('href', 'cancelar_solicitacao.php?id=' + id + '&id_usuario=' + id_usuario_logado);
            $('#acao_texto').text("Confimação de cancelamento da solicitação:");
            $('#acao_usuario').text(usuario);
            $('#acao_descricao').html(descricao);
            $('#confirm').modal({ show: true });
        }

        function mostraAnexos(id_solicitacao, pasta, solicitacao, id_interacao,exclur=false) {

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
                        montarListaArquivos(id_solicitacao, pasta, arquivos, exclur)
                    );

                    $('#modalArquivos').modal('show');
                }
            });
        }
        function montarListaArquivos(id_solicitacao, pasta, itens, exclur) {

            let html = '';

            itens.forEach(function(item) {

                // Se for um diretório
                if (item.tipo === 'diretorio') {
                    return;
                }

                // Se for um arquivo
                const link = `${pasta}/${item.caminho.replace(/^.*?\//, '')}`;

                if (exclur) {
                    html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center mb-2">

                        <div class="d-flex align-items-center">
                            <i class="fa fa-file mr-2"></i>
                            <span>${item.nome}</span>
                        </div>

                        <div>

                            <a href="${link}" target="_blank" 
                            class="btn btn-primary btn-sm mr-1"
                            title="Baixar arquivo"
                            download>
                                <i class="fa fa-download"></i>
                            </a>

                            <button type='button' class='btn btn-danger btn-sm' title='Excluir arquivo' onclick="excluirArquivo('${id_solicitacao}','${pasta}','${link}')"><i class='fa fa-times'></i></button>

                        </div>
                    </div>`;
                } else {
                    html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center mb-2">

                        <div class="d-flex align-items-center">
                            <i class="fa fa-file mr-2"></i>
                            <span>${item.nome}</span>
                        </div>

                        <div>

                            <a href="${link}" target="_blank" 
                            class="btn btn-primary btn-sm mr-1"
                            title="Baixar arquivo"
                            download>
                                <i class="fa fa-download"></i>
                            </a>

                        </div>

                    </div>
                `;
                }
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
                </div>

            </div>
        `;
            });

            return html;
        }
        $(document).on('change', '.custom-file-input', function () {

            const arquivo = this.files[0];

            if (!arquivo) {
                return;
            }

            // Atualiza o nome do arquivo no label
            $(this)
                .next('.custom-file-label')
                .text(arquivo.name);

            // Verifica se já existe algum input vazio
            let existeInputVazio = false;

            $('.custom-file-input').each(function () {
                if (this.files.length === 0) {
                    existeInputVazio = true;
                    return false;
                }
            });

            // Se já existe um input vazio, não cria outro
            if (existeInputVazio) {
                return;
            }

            // Cria um novo input
            const indice = $('.custom-file-input').length;

            $('#container-anexos').append(`
        <div class="custom-file mb-2">
            <input type="file"
                   class="custom-file-input"
                   id="anexo_${indice}"
                   name="anexos[]">

            <label class="custom-file-label" for="anexo_${indice}">
                Escolher arquivo...
            </label>
        </div>
    `);
        });


    </script>
    <style>
        body {
            font-size: small;
        }

        .campo-obrigatorio {
            border: 2px solid #dc3545 !important;
            border-radius: 4px;
            animation: piscarCampo 0.3s ease-in-out 3;
        }

        @keyframes piscarCampo {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            50% {
                transform: translateX(4px);
            }

            75% {
                transform: translateX(-4px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .mensagem-erro {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
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
                <?php
                include_once('actions/ManterInteracaoSolicitacao.php');
                include_once('actions/ManterSolicitacao.php');
                include_once('actions/ManterUsuario.php');
                include_once('actions/ManterCategoria.php');

                $manterInteracaoSolicitacao = new ManterInteracaoSolicitacao();
                $manterSolicitacao = new ManterSolicitacao();
                $manterCategoria = new ManterCategoria();
                $manterUsuario = new ManterUsuario();



                if (isset($_REQUEST['id'])) {
                    $id_solicitacao = $_REQUEST['id'];
                    $solicitacao = $manterSolicitacao->getSolicitacaoPorId($id_solicitacao);
                    $usuario = $manterUsuario->getUsuarioPorId($solicitacao->solicitante);
                    $editar = false;

                    if ($solicitacao->status == 1 || $solicitacao->status == 4) {
                        $editar = true;
                    }

                    $pasta = './anexos_solicitacao/' . $solicitacao->id . "_solicitacao";

                    $link_arquivo = "#";
                    $onclick = "";
                    $titulo = "";
                    $icone_arquivo = "";
                    $totalArquivos = 0;
                    $arquivos = [];

                    if (is_dir($pasta)) {
                        $iterator = new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator($pasta, RecursiveDirectoryIterator::SKIP_DOTS)
                        );

                        foreach ($iterator as $arquivo) {
                            if ($arquivo->isFile()) {
                                $arquivos[] = $arquivo->getPathname();
                            }
                        }

                        $totalArquivos = count($arquivos);

                        if ($totalArquivos === 1) {
                            $link_arquivo = $arquivos[0];
                            $titulo = 'Baixar anexo';
                            $icone_arquivo = "fa fa-file fa-2x text-info";
                        } elseif ($totalArquivos > 1) {
                            $onclick = "onclick=\"mostraAnexos($solicitacao->id, '$pasta'); return false;\"";
                            $titulo = 'Visualizar anexos';
                            $icone_arquivo = "fa fa-folder-open fa-2x text-info";
                        }
                    }

                    $possui_arquivo = $solicitacao->anexos
                        ? "<a href='$link_arquivo' title='$titulo' class='d-inline-block' $onclick><i class='$icone_arquivo'></i></a>"
                        : "---";

                    $solicitante = $manterSolicitacao->getSolicitantePorIdUsuario($solicitacao->solicitante);

                    echo "<tr>";
                    ?>
                    <div class="container-fluid">
                        <!-- Exibe dados da  tarefa -->
                        <div class="card mb-3 border-primary" style="max-width: 800px;">
                            <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                                <div class="row">
                                    <div class="col c2 ml-2">
                                        <div class="h6 text-xs text-white font-weight-bold text-uppercase mb-1">Solicitação
                                        </div>
                                        <div class="h5 mb-0 text-white font-weight-bold">
                                            [<small><?= $solicitacao->id ?></small>]
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-tasks fa-3x text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="c1 ml-4">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Aberto em:</div>
                                        <div class="mb-0">
                                            <?= date('d/m/Y H:i', strtotime($solicitacao->data_abertura)) ?>
                                        </div>
                                    </div>
                                    <div class="c2 ml-4">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Aberto por:</div>
                                        <div class="mb-0">
                                            <?= $usuario->nome ?>
                                        </div>
                                    </div>
                                    <div class="c3 ml-4">
                                        <!-- <?php
                                        $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
                                        switch ($solicitacao->status) {
                                            case 0:
                                                $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
                                                break;
                                            case 1:
                                                $txt_status = '<i class="fa fa-hourglass-start fa-2x text-warning"></i>';
                                                break;
                                            case 2:
                                                $txt_status = '<i class="fa fa-check-circle fa-2x text-success"></i>';
                                                break;
                                            case 3:
                                                $txt_status = '<i class="fa fa-ban fa-2x text-danger"></i>';
                                                break;
                                        }
                                        ?> -->
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Status</div>
                                        <div class="mb-0"><?= $txt_status ?></div>
                                    </div>
                                    <div class="c4 ml-4">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Anexo</div>
                                        <div class="mb-0"><?= $possui_arquivo ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="c1 ml-4">                                        
                                        <h6 class="mt-3 ml-2 card-title">Processo</h6>
                                        <p class=" ml-2 card-text"><?= $solicitacao->chave ?></p>
                                    </div>
                                    <?php
                                    if (!empty($solicitacao->assunto)) { ?>
                                    <div class="c2 ml-4">
                                        <h6 class="mt-3 ml-2 card-title">Parte autora</h6>
                                    <p class=" ml-2 card-text"><?= $solicitacao->assunto ?></p>
                                    </div>                                                                    
                                    <?php } ?>
                                </div>
                                <h6 class="mt-3 ml-2 card-title">Descrição da solicitação</h6>
                                <p class=" ml-2 card-text"><?= $solicitacao->descricao ?></p>

                                <br />
                                <div class="row">
                                    <div class="c1 ml-4" style="width: 80%">
                                        <?php
                                        if ($usuario_logado->id == $solicitacao->usuario || $usuario_logado->perfil <= 2 || $usuario_logado->perfil == 9) {
                                            if ($solicitacao->status == 2) {
                                                ?>
                                                <p class="text-success font-weight-bold mb-0">
                                                    <i class="fa fa-check-circle"></i>
                                                    Esta solicitação foi finalizada.
                                                </p>
                                                <?php
                                            } else if ($solicitacao->status == 1 || $solicitacao->status == 4) {
                                                ?>
                                                    <button class="btn btn-success btn-sm" type="button" onclick="interacao()">
                                                        <i class="fa fa-plus-circle text-white" aria-hidden="true"></i> Nova
                                                        interação
                                                    </button>
                                                <?php

                                            } else if ($solicitacao->status == 3) {
                                                ?>
                                                        <p class="text-danger font-weight-bold mb-0">
                                                            <i class="fa fa-ban"></i>
                                                            Esta solicitação foi cancelada.
                                                        </p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        }
                }
                ?>
                            </div>
                        </div>
                    </div>
                    <!-- fim da exibição -->
                    <?php

                    ?>

                    <!-- ETAPAS -->
                    <?php include './get_interacao_solicitacoes_dijur.php'; ?>
                    <!-- FIM ETAPAS -->
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

    <!-- Modal -->
    <div class="modal fade" id="nova" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="form_cadastro" action="registrar_interacao_solicitacao.php" method="post"
                enctype="multipart/form-data">
                <input type="hidden" id="id_solicitacao" name="id_solicitacao" value="<?= $solicitacao->id ?>" />
                <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $usuario_logado->id ?>" />
                <input type="hidden" id="id_setor" name="id_setor" value="<?= $usuario_logado->setor ?>" />
                <input type="hidden" id="diretorio" name="diretorio" value="<?= $pasta ?>" />
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TituloModalCentralizado">Nova interação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="editor">
                                <strong>Interação</strong>
                            </label>

                            <div style="width: 100%; height: 95px;" id="editor"></div>

                            <input type="hidden" id="texto" name="texto">
                        </div>

                        <div class="form-group">
                            <label>
                                <strong>Anexos</strong>
                            </label>

                            <div id="container-anexos">
                                <div class="custom-file mb-2">
                                    <input type="file" class="custom-file-input" id="anexo_0" name="anexos[]">

                                    <label class="custom-file-label" for="anexo_0">
                                        Escolher arquivo...
                                    </label>
                                </div>
                            </div>

                            <small class="form-text text-muted">
                                Você pode anexar mais de um arquivo. Um novo campo será exibido automaticamente após a
                                seleção de um arquivo.
                            </small>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <?php
                        if ($usuario_logado->id != $solicitacao->usuario && ($usuario_logado->perfil <= 2 || $usuario_logado->perfil == 9)) {
                            ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" name="finalizar" id="finalizar">
                                <label class="form-check-label" for="finalizar">Finalizar solicitação</label>
                            </div>
                            <?php
                        }
                        ?>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i>
                            Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal reabrir -->
    <div class="modal fade" id="confirm" role="dialog">
        <div class="modal-dialog modal-lm">

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
                        <strong>"<span id="acao_descricao"></span>"</strong>
                    <form action="reabrir_chamado.php" id="form_reabertura" method="POST">
                        <p><span id="acao_motivo"></span><br />
                        <div style="width: 100%; height: 95px;" id="editor_motivo"></div>
                        <div id="erro_motivo" class="mensagem-erro">
                            Informe o motivo da reabertura.
                        </div>
                        <input type='hidden' id="motivo_reabertura" class="mensagem-erro" name="motivo_reabertura">
                        <input type="hidden" id="usuario_logado_chamado" name="usuario_logado_chamado"
                            value="<?= $usuario_logado->id ?>">
                        <input type='hidden' id="id_chamado_reabertura" name="id_chamado_reabertura"
                            value="<?= $solicitacao->id ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="acao">Confirmar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Desistir</button>
                </div>
                </form>
            </div>
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