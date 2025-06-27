<?php
$mod = 17; // Define a variável de módulo
require_once('./verifica_login.php'); // Faz a verificação de login
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
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.bubble.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.core.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <!-- jQuery e Bootstrap -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- SB Admin JS -->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Plugins adicionais -->

    <!-- DataTables JS -->
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    <!-- Froala Editor JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- JS de inicialização do DataTable e Froala Editor -->
    <script type="text/javascript" class="init">
        $(document).ready(function () {

            // Inicialização do DataTable
            $('#planejamentos').DataTable();
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
            const quillMissao = new Quill('#editor-missao', quillOpcoes);
            const quillVisao = new Quill('#editor-visao', quillOpcoes);
            document.getElementById('form_planejamento').addEventListener('submit', function () {
                // Coloca no campo hidden para enviar via POST
                var visaoHTML = quillVisao.root.innerHTML;
                var missaoHTML = quillMissao.root.innerHTML;
                document.querySelector('input[name="visao"]').value = visaoHTML;
                document.querySelector('input[name="missao"]').value = missaoHTML;
            });
            // Função para preencher o formulário ao editar
            function alterar(id, nome, ano_inicio, ano_fim) {
                $('#id').val(id);
                $('#nome').val(nome);
                $('#ano_inicio').val(ano_inicio);
                $('#ano_fim').val(ano_fim);
                quillMissao.root.innerHTML = $('#'+id+'_missao').val();
                quillVisao.root.innerHTML =  $('#'+id+'_visao').val();
                $('#form_planejamento').collapse("show");
            }
            function novo() {
                quillMissao.root.innerHTML = "";
                quillVisao.root.innerHTML = "";
                $('#form_planejamento').collapse("show");
            }
            window.alterar = alterar; // Torna a função global
            window.novo = novo; // Torna a função global
        });
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_planejamento.php?id=' + id);
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
                <?php include 'top_bar.php'; ?>
                <?php
                require_once 'actions/ManterPlanejamento.php';
                $planejamentos = new ManterPlanejamento();
                $planejamento = $planejamentos->listar();
                ?>
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
                                <button id="btn_cadastrar" onclick="novo()" class="btn btn-outline-light btn-sm"
                                    type="button" data-toggle="collapse" data-target="#form_planejamento"
                                    aria-expanded="false" aria-controls="form_planejamento">
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
                                            <th scope="col" style="width:50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_planejamentos.php'); ?>
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
                    <p>Deseja excluir o planejamento <strong>"<span id="excluir"></span>"</strong>?</p>
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