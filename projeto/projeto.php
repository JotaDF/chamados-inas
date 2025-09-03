<?php
$mod = 18;
require_once './verifica_login.php';
?>

<head>
    <html lang="pt-BR">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Projetos - INAS</title>
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
        var quillTap;
        var listaO = [];
        <?php
        include 'actions/ManterProjeto.php';
        include 'actions/ManterObjetivo.php';
        $manterProjeto = new ManterProjeto();
        $manterObjetivo = new ManterObjetivo();
        $objetivos = $manterObjetivo->listar();
        foreach ($objetivos as $o) { ?>
            item = { id: "<?= $o->id ?>", nome: "<?= strtoupper($o->descricao) ?>" };
            listaO.push(item);
        <?php } ?>
        $(document).ready(function () {
            $('#projetos').DataTable();
            carregaObjetivos(0);
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
            quillTap = new Quill('#editor-tap', quillOpcoes);
            document.getElementById('form_projeto').addEventListener('submit', function () {
                const quillTapHTML = quillTap.root.innerHTML;
                document.querySelector('input[name="tap"]').value = quillTapHTML;
            });
        });
        function excluir(id, nome) {
            $('#delete').attr('href', 'del_projeto.php?id=' + id);
            $('#excluir').text(nome);
            $('#confirm').modal({ show: true });
        }

        function novo() {
            quillTap.root.innerHTML = "";
            carregaObjetivos(0);
            $('#form_projeto').collapse("show");
        }

        function alterar(id, nome, descricao, orcamento, status, objetivo) {
            $('#id_projeto').val(id);
            $('#nome').val(nome);
            $('#descricao').val(descricao);
            $('#orcamento').val(orcamento);
            quillTap.root.innerHTML = $('#' + id + '_tap').val();
            $('#status').val(status);
            carregaObjetivos(objetivo);
            $('#form_projeto').collapse("show");
        }

        function selectByText(select, text) {
            $(select).find('option:contains("' + text + '")').prop('selected', true);
        }

        function carregaObjetivos(id_atual) {
            var html = '<option value="">Selecione um Objetivo</option>';
            for (var i = 0; i < listaO.length; i++) {
                var option = listaO[i];
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
            $('#objetivo').html(html);
        }
        const mascaraMoeda = (event) => {
            const onlyDigits = event.target.value
                .split("")
                .filter(s => /\d/.test(s))
                .join("")
                .padStart(3, "0")
            const digitsFloat = onlyDigits.slice(0, -2) + "." + onlyDigits.slice(-2)
            event.target.value = maskCurrency(digitsFloat)
        }

        const maskCurrency = (valor, locale = 'pt-BR', currency = 'BRL') => {
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency
            }).format(valor)
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
                <div class="container-fluid">
                    <?php include './form_projeto.php'; ?>
                    <div class="card mb-4 border-primary" style="max-width:1000px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-folder fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Projeto</span>
                            </div>
                            <div class="col text-right" style="max-width:20%">
                                <button id="btn_cadastrar" onclick="limpaEditor()" class="btn btn-outline-light btn-sm"
                                    type="button" data-toggle="collapse" data-target="#form_projeto"
                                    aria-expanded="false" aria-controls="form_projeto">
                                    <i class="fa fa-plus-circle text-white" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="projetos" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="width:50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_projeto.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php' ?>
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
                        <p>Deseja excluir o Projeto: <strong>"<span id="excluir"></span>"</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>