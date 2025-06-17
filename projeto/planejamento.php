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
    <script>
        function excluir(id, nome, missao) {
            $('#delete').attr('href', 'del_planejamento.php?id=' + id);
            $('#excluir').text(nome + " / " + missao);
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

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_style.min.css' rel='stylesheet'
        type='text/css' />
    <script type='text/javascript'
        src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/js/froala_editor.pkgd.min.js'></script>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            // Inicialização do DataTables
            $('#planejamentos').DataTable();
            // Definição de ícones e comandos customizados do Froala
            FroalaEditor.DefineIcon('clear', { NAME: 'remove', SVG_KEY: 'remove' });
            FroalaEditor.RegisterCommand('clear', {
                title: 'Limpar',
                focus: false,
                undo: true,
                refreshAfterCallback: false,
                callback: function () {
                    this.html.set('');
                    this.events.focus();
                }
            });
            var froalaOptions = {
                toolbarButtons: [
                    ['undo', 'redo', 'bold', 'underline', 'italic', 'align'],
                    ['alert', 'clear', 'insert']
                ],
                quickInsertTags: true,
                placeholderText: false,
                charCounterMax: 1000,
            };
            var froalaMissao = new FroalaEditor('#froala-editor', froalaOptions);
            var froalaVisao = new FroalaEditor('#froala-editor-visao', froalaOptions);

            // A função alterar que define os valores
            function alterar(id, nome, ano_inicio, ano_fim, missao, visao) {
                console.log(id)
                $('#id').val(id);
                $('#nome').val(nome);
                $('#ano_inicio').val(ano_inicio);
                $('#ano_fim').val(ano_fim);
                // Agora usa as instâncias já criadas 
                froalaMissao.html.set(missao);
                froalaVisao.html.set(visao);
                $('#form_planejamento').collapse("show");
            }
            window.alterar = alterar;
        });
    </script>
</body>

</html>