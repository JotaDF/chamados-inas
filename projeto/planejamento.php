<?php
$mod = 17;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Planejamento - INAS</title>

    <!-- FontAwesome -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- Bootstrap e DataTables CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <!-- Froala Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_style.min.css" rel="stylesheet"
        type="text/css" />

    <style>
        body {
            font-size: small;
        }
    </style>

    <script>

    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_planejamento.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'top_bar.php' ?>
                <div class="container-fluid">
                    <?php include './form_planejamento.php'; ?>
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Planejamento</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" class="btn btn-outline-light btn-sm" type="button"
                                    data-toggle="collapse" data-target="#form_planejamento" aria-expanded="false"
                                    aria-controls="form_planejamento">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="planejamentos"
                                    class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center;">ID</th>
                                            <th scope="col" style="text-align: center;">Nome</th>
                                            <th scope="col" style="text-align: center;">Ano Início</th>
                                            <th scope="col" style="text-align: center;">Ano Fim</th>
                                            <th scope="col" style="text-align: center;">Missão</th>
                                            <th scope="col" style="text-align: center;">Visão</th>
                                            <th scope="col" style="width:50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_planejamentos.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include 'rodape.php' ?>
        </div>
    </div>
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
                    <p>Deseja excluir o planejamento <strong>"<span id="excluir"></span>"</strong>?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery e Bootstrap -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- SB Admin JS -->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Plugins adicionais -->
    <script src="js/jquery.mask.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <!-- Froala Editor JS -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/js/froala_editor.pkgd.min.js"></script>

</body>

</html>

<script type="text/javascript" class="init">
    $(document).ready(function () {  // Aguarda o carregamento completo do DOM para iniciar o script

        // Inicialização do DataTables na tabela com ID 'planejamentos'
        $('#planejamentos').DataTable();

        // Definição de um novo ícone personalizado no Froala Editor chamado 'clear'
        FroalaEditor.DefineIcon('clear', { NAME: 'remove', SVG_KEY: 'remove' });

        // Registro de um novo comando chamado 'clear' no Froala Editor
        FroalaEditor.RegisterCommand('clear', {
            title: 'Limpar',               // Título do comando (aparece como tooltip)
            focus: false,                  // Não força foco após executar
            undo: true,                    // Permite desfazer a ação
            refreshAfterCallback: false,   // Não precisa de refresh após executar
            callback: function () {        // Ação do comando: limpa o conteúdo do editor
                this.html.set('');         // Limpa o conteúdo HTML do editor
                this.events.focus();       // Coloca o cursor de volta no editor
            }
        });

        // Opções de configuração padrão para os dois editores Froala (Missão e Visão)
        var froalaOptions = {
            toolbarButtons: [              // Botões disponíveis na barra de ferramentas
                ['undo', 'redo', 'bold', 'underline', 'italic', 'align'],
                ['alert', 'clear', 'insert']  // Inclui o botão customizado 'clear'
            ],
            quickInsertTags: true,          // Permite inserção rápida de elementos
            placeholderText: false,         // Não exibe placeholder dentro do editor
            charCounterMax: 1000,           // Limita o número máximo de caracteres a 1000
        };

        // Inicialização do Froala Editor no campo de Missão (ID: froala-editor)
        var froalaMissao = new FroalaEditor('#froala-editor', froalaOptions);

        // Inicialização do Froala Editor no campo de Visão (ID: froala-editor-visao)
        var froalaVisao = new FroalaEditor('#froala-editor-visao', froalaOptions);

        // Função para preencher o formulário com os dados de um planejamento selecionado para edição
        function alterar(id, nome, ano_inicio, ano_fim, missao, visao) {
            console.log(id);                            // Exibe o ID no console (debug)
            $('#id').val(id);                           // Preenche o campo oculto 'id'
            $('#nome').val(nome);                       // Preenche o campo 'nome'
            $('#ano_inicio').val(ano_inicio);           // Preenche o campo 'ano_inicio'
            $('#ano_fim').val(ano_fim);                 // Preenche o campo 'ano_fim'
            froalaMissao.html.set(missao);              // Insere o conteúdo da missão no editor Froala
            froalaVisao.html.set(visao);                // Insere o conteúdo da visão no editor Froala
            $('#form_planejamento').collapse("show");   // Exibe o formulário expandindo o collapse
        }

        // Torna a função 'alterar' acessível globalmente (pode ser chamada via onclick no HTML)
        window.alterar = alterar;
    });
    function excluir(id, nome, missao) {
        $('#delete').attr('href', 'del_planejamento.php?id=' + id);
        $('#excluir').text(nome + " / " + missao);
        $('#confirm').modal({ show: true });
    }
</script>
</body>

</html>