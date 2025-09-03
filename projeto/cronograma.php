<?php
$mod = 18;
require_once('./verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conograma</title>
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
        var quillEditor;
        $(document).ready(function () {
            $('#cronogramas').DataTable();
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
            quillDescricao = new Quill('#editor', quillOpcoes);
            document.getElementById('form_cronograma').addEventListener('submit', function () {
                var descricaoHTML = quillDescricao.root.innerHTML;
                document.querySelector('input[name="descricao"]').value = descricaoHTML;
            });
        });

        function limpaEditor() {
        quillDescricao.root.innerHTML = "";
        }

        function alterar(id, inicio_prev, fim_prev, inicio_real, fim_real, status) {
            $('#id_cronograma').val(id);
            quillDescricao.root.innerHTML = $('#' + id + '_descricao').val();
            $('#inicio_prev').val(inicio_prev);
            $('#fim_prev').val(fim_prev);
            $('#inicio_real').val(inicio_real);
            $('#fim_real').val(fim_real);
            $('#status').val(status);
            $('#descricao').focus();
        }
        function excluir(id, descricao, eap_item) {
            $('#delete').attr("href", "del_cronograma.php?id=" + id + "&eap=" + eap_item);
            $('#excluir').html(descricao);
            $('#confirm').modal();
        }
        function iniciar(id, eap_item, descricao) {
            $('#id_cronograma_inicio').val(id);
            $('#id_eap_item_inicio').val(eap_item);
            $('#descricao_modal_iniciar').html(descricao);
            $('#enviar_data_real');
            $('#data_inicio_real').modal();
        }
        function finalizar(id, eap_item, descricao) {
            $('#id_cronograma_fim').val(id);
            $('#id_eap_item_fim').val(eap_item);
            $('#descricao_modal_finalizar').html(descricao);
            $('#enviar_data_real');
            $('#data_fim_real').modal();
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
                require_once('actions/ManterCronograma.php');
                require_once('actions/ManterEapItem.php');
                $id_eap_item = $_GET['id'];
                $id_projeto = $_GET['p'];
                $manterEapItem = new ManterEapItem();
                $manterCronograma = new ManterCronograma();
                $eap_item = $manterEapItem->getEapItemPorId($id_eap_item);
                ?>
                <div class="container-fluid">
                    <div class="card mb-3 border-primary" style="max-width: 800px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">Conograma </div>
                                </div>
                                <div>
                                    <a href="eap_item.php?id= <?php echo $id_projeto ?>" class="btn btn-sm text-white border">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-clock fa-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="c1 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                                    <div class="mb-0"><?= $id_eap_item ?></div>
                                </div>
                                <div class="c2 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Nome do Eap Item:
                                    </div>
                                    <div class="mb-0"><?= $eap_item->nome ?></div>
                                </div>
                            </div>
                            <br />
                            <p class=" ml-2 card-text">
                                <span class="mt-3 ml-2 h6 card-title">Cronogramas</span>
                            <form id="form_cronograma" class="row g-3" action="save_cronograma.php" method="post">
                                <!-- Hidden Fields -->
                                <input type="hidden" id="id_eap_item" name="id_eap_item" value="<?= $id_eap_item ?>" />
                                <input type="hidden" id="id_cronograma" name="id_cronograma" />
                                <!-- Descrição -->

                                <div class="col-md-6 mb-3">
                                    <label for="inicio_prev" class="form-label">Início Previsto</label>
                                    <input type="date" id="inicio_prev" name="inicio_prev"
                                        class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fim_prev" class="form-label">Fim Previsto</label>
                                    <input type="date" id="fim_prev" name="fim_prev"
                                        class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <div id="editor"></div>
                                    <input type="hidden" name="descricao" id="descricao">
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2  mt-5">
                                    <button type="reset" class="btn btn-danger btn-sm" onclick="limpaEditor()">
                                        <i class="fas fa-minus-square"></i> Cancelar
                                    </button>
                                    &nbsp&nbsp&nbsp
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i> Salvar
                                    </button>
                                </div>
                            </form>

                            </p>
                        </div>
                    </div>
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-clock fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Cronogramas</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="cronogramas"
                                    class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 10%;">ID</th>
                                            <th scope="col" style="width: 10%;">Descrição</th>
                                            <th scope="col" style="width: 10%;">Incio Previsto</th>
                                            <th scope="col" style="width: 10%;">Incio Real</th>
                                            <th scope="col" style="width: 10%;">Fim Previsto</th>
                                            <th scope="col" style="width: 10%;">Fim Real</th>
                                            <th scope="col" style="width: 5%;">Status</th>
                                            <th scope="col" style="width: 10%;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_cronograma.php') ?>
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
                        <p>Deseja excluir o Conograma: <strong>"<span id="excluir"></span>"</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="data_inicio_real" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar data de Inicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Descrição: <span id="descricao_modal_iniciar"></span></strong></p>
                        <form action="save_data_cronograma.php" method="POST">
                            <input type="hidden" id="id_cronograma_inicio" name="id_cronograma">
                            <input type="hidden" id="id_eap_item_inicio" name="id_eap_item">
                            <div class="col-md-10 mb-3">
                                <label for="inicio_real" class="form-label">Data de Inicio</label>
                                <input type="date" id="inicio_real" name="inicio_real" value="<?= date('Y-m-d'); ?>"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" id="enviar_data_real">Salvar</a>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-secondary">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="data_fim_real" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar data de Finalização</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Descrição: <span id="descricao_modal_finalizar"></span></strong></p>
                        <form action="save_data_cronograma.php" method="POST">
                            <input type="hidden" id="id_cronograma_fim" name="id_cronograma">
                            <input type="hidden" id="id_eap_item_fim" name="id_eap_item">
                            <div class="col-md-10 mb-3">
                                <label for="fim_real" class="form-label">Data de Finalização</label>
                                <input type="date" id="fim_real" name="fim_real" value="<?= date('Y-m-d'); ?>"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" id="enviar_data_real">Salvar</a>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-secondary">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>