<?php
$mod = 18;
require_once("./verifica_login.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAP ITEM - Inas</title>
    <!-- FontAwesome -->
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
    <script>
        let listaE = [];
        <?php
        require_once("actions/ManterEapItem.php");
        $manterEapItem = new ManterEapItem;
        $id_projeto = $_GET['id'];
        $eap_item = $manterEapItem->getEapItemPorIdProjeto($id_projeto);
        foreach ($eap_item as $eap) {
            ?>
            item = {
                id: <?= (int) $eap->id ?>,
                nome: "<?= $eap->nome ?>",
                id_eap_item: <?= $eap->id_eap_item !== null ? $eap->id_eap_item : 'null' ?>
            }
            listaE.push(item);
            <?php
        }
        ?>
        function montaOptions(lista, idPai = null, nivel = 0) {
            let html = "";
            lista
                .filter(item => item.id_eap_item === idPai)
                .forEach(item => {
                    const indentacao = "&nbsp;".repeat(nivel * 4) + (nivel > 0 ? "- " : "");
                    html += '<option value="' + item.id + '">' + indentacao + item.nome + '</option>';
                    // chamada recursiva
                    html += montaOptions(lista, item.id, nivel + 1);
                });
            return html;
        }

        $(document).ready(function () {
           carregaEapItem(eap_item_pai)
            $('#eap_item').DataTable();
        });
        function limpaCampos() {
            carregaEapItem(0);
        }
        function alterar(id, nome, eap_item_pai) {
            console.log(id);
            $('#id').val(id);
            $('#nome').val(nome);
            carregaEapItem(eap_item_pai)
        }
        function excluir(id, nome, projeto) {
            $('#delete').attr('href', 'del_eap_item.php?id=' + id + '&id_projeto=' + projeto);
            $('#excluir').text(nome);
            $('#confirm').modal({ show: true });
        }

        function carregaEapItem(id_atual) {
            var html = '<option value="">Selecione um EAP ITEM</option>';
            for (var i = 0; i < listaE.length; i++) {
                var option = listaE[i];
                var select = "";
                if (id_atual > 0 && id_atual == option.id) {
                    var selected = " selected ";
                } else {
                    selected = "";
                }
                html += '<option value="' + option.id + '" ' + selected + '>' + option.nome + '</option>';
            }
            $('#eap_item_pai').html(html);
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
                require_once('actions/ManterProjeto.php');
                $manterProjeto = new ManterProjeto();
                $projeto = $manterProjeto->getNomeProjetoPorId($id_projeto);
                ?>
                <div class="container-fluid">
                    <div class="card mb-3 border-primary" style="max-width: 800px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">EAP ITEM</div>
                                </div>
                                <div>
                                    <a href="projeto.php" class="btn btn-sm text-white border">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-retweet fa-3x text-white"></i>
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
                            </div>
                            <br />
                            <p class=" ml-2 card-text">
                                <span class="mt-3 ml-2 h6 card-title">EAP ITEM</span>
                            <form id="form_eap_item" action="save_eap_item.php" method="post">
                                <input type="hidden" id="id_projeto" name="id_projeto" value="<?= $id_projeto ?>" />
                                <input type="hidden" id="id" name="id" />
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                                    <div class="col-sm-10 mb-2">
                                        <input type="text" id="nome" name="nome" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="indicador" class="col-sm-2 col-form-label">EAP ITEM:</label>
                                    <div class="col-sm-10 mb-2">
                                        <select id="eap_item_pai" name="id_eap_item_pai"
                                            class="form-control form-control-sm">
                                            <option value="">Selecione o Eap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-auto">
                                        <button type="reset" class="btn btn-danger btn-sm" onclick="limpaCampos()">
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
                                <i class="fa fa-retweet fa-3x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">EAP</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="eap_item" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Pai</th>
                                            <th scope="col" style="width: 50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_eap_item.php') ?>
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

</html>