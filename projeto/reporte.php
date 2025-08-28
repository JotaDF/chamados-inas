<?php
$mod = 18;
require_once('./verifica_login.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Inas</title>
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
        let listaI = [];
        <?php
        require_once('actions/ManterProjeto.php');
        require_once('actions/ManterIndicador.php');
        require_once('actions/ManterReporte.php');
        $manterIndicador = new ManterIndicador();
        $manterProjeto = new ManterProjeto();
        $manterReporte = new ManterReporte();
        $id_projeto = isset($_GET['id']) ? $_GET['id'] : 0;
        $projeto = $manterProjeto->getProjetoPorId($id_projeto);
        $indicadores = $manterIndicador->getIndicadorPorObjetivo($projeto->objetivo);

        foreach ($indicadores as $i) {
            ?>
            item = { id: "<?= $i->id ?>", nome: "<?= $i->nome ?>" };
            listaI.push(item);
            <?php
        }
        ?>

        $(document).ready(function () {
            $('#reportes').DataTable();
            carregaIndicador(0);
        });

        function excluir(id, conteudo, projeto) {
            $('#delete').attr('href', 'del_reporte.php?id=' + id + '&id_projeto=' + projeto);
            $('#excluir').text(conteudo);
            $('#confirm').modal({ show: true });
        }
        function alterar(id, conteudo, indicador, tipo) {
            $('#id_reporte').val(id);
            $('#conteudo').val(conteudo);
            $('#tipo').val(tipo);
            carregaIndicador(indicador);
        }
        function carregaIndicador(id_atual) {
            var html = '<option value="">Selecione um Indicador</option>';
            for (var i = 0; i < listaI.length; i++) {
                var option = listaI[i];
                var selected = "";
                if (id_atual > 0) {
                    if (option.id == id_atual) {
                        selected = " selected ";
                    } else {
                        selected = "";
                    }
                }
                html += '<option value="' + option.id + '" ' + selected + '>' + option.nome + '</option>';
            }
            $('#indicador').html(html);
        }

        function limpaCampos() {
            carregaIndicador(0);
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
                    <div class="card mb-3 border-primary" style="max-width: 900px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">Reportes </div>
                                </div>
                                <div>
                                    <a href="projeto.php" class="btn btn-sm text-white border">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-list fa-2x text-white"></i>
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
                                <div class="c4 ml-4">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">STATUS</div>
                                    <div class="mb-0"><?= $projeto->status ?></div>
                                </div>
                            </div>
                            <br />
                            <p class=" ml-2 card-text">
                                <span class="mt-3 ml-2 h6 card-title">Reportes</span>
                            <form id="form_reporte" action="save_reporte.php" method="post">
                                <input type="hidden" id="id_projeto" name="id_projeto" value="<?= $id_projeto ?>" />
                                <input type="hidden" id="id_reporte" name="id_reporte" />
                                <div class="form-group row">
                                    <label for="usuario" class="col-sm-2 col-form-label">Conteúdo:</label>
                                    <div class="col-sm-10 mb-2">
                                        <input type="text" id="conteudo" name="conteudo"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tipo" class="col-sm-2 col-form-label">Tipo:</label>
                                    <div class="col-sm-10 mb-2">
                                        <input type="text" id="tipo" name="tipo" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="indicador" class="col-sm-2 col-form-label">Indicador:</label>
                                    <div class="col-sm-10 mb-2">
                                        <select id="indicador" name="indicador" class="form-control form-control-sm">
                                            <option value="">Selecione o Indicador</option>
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
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-list fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Reportes</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="reportes" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Conteúdo</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Data</th>
                                            <th scope="col" style="width: 50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_reporte.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php' ?>
        </div>
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
                    <p>Deseja excluir o Projeto: <strong>"<span id="excluir"></span>"</strong>?</p>
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