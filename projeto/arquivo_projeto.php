<?php
$mod = 18;
require_once('./verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquivos do Projeto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
            $('#arquivos').DataTable({
                responsive: true,
            });
        });
        function excluir(id, nome, url, projeto) {
            $('#delete').attr('href', 'del_arquivo_projeto.php?id=' + id + "&projeto=" + projeto + '&url=' + url);
            $('#excluir').text(nome);
            $('#confirm').modal('show');
        }
    </script>
    <style>
        body {
            font-size: small;
        }

        .btn_arquivo {
            margin-top: 10px;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_planejamento.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'top_bar.php';
                $id_projeto = $_GET['id'];
                require_once('actions/ManterArquivo.php');
                require_once('actions/ManterProjeto.php');
                $manterProjeto = new ManterProjeto();
                $projeto = $manterProjeto->getNomeProjetoPorId($id_projeto);
                $manterArquivo = new ManterArquivo();
                ?>
                <div class="container-fluid">
                    <div class="card-body mt-4">
                        <div class="card mb-4 border-primary" style="max-width:800px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Upload</span>
                                </div>
                                <div class="col-sm ml-0 text-right" style="max-width:50px;">
                                    <i class="fa fa-upload fa-2x text-white"></i>
                                </div>
                            </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="c1 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                                            <div class="mb-0"><?= $id_projeto ?></div>
                                        </div>
                                        <div class="c2 ml-4">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Nome do
                                                Projeto:
                                            </div>
                                            <div class="mb-0"><?= $projeto->nome ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php

                                include './form_arquivo_projeto.php';

                                $msg = "";
                                if (isset($_REQUEST['msg'])) {
                                    $id_msg = $_REQUEST['msg'];

                                    if ($id_msg == 1) {
                                        $msg = "Arquivo processado com sucesso!";
                                        ?>
                                        <script>
                                            document.getElementById('atualiza').disabled = false;
                                        </script>
                                        <?php
                                    } else if ($id_msg == 2) {
                                        $msg = "Erro ao processar arquivo!";
                                    } else if ($id_msg == 3) {
                                        $msg = "Situação atualizada com sucesso!";
                                    }
                                }
                                ?>
                        </div>
                        <div class="card mb-4 border-primary" style="max-width:800px">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0 text-right" style="max-width:50px;">
                                    <i class="fa fa-folder-open fa-2x text-white"></i>
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Arquivos</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="arquivos"
                                        class="table-sm table-striped table-bordered dt-responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">URL</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col" style="width: 25px;">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include('get_arquivos_projeto.php') ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php' ?>
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
                    <p>Deseja excluir o Arquivo: <strong>"<span id="excluir"></span>"</strong>?</p>
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