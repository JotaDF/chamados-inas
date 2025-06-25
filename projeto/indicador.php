<?php
$mod = 17;
require_once './verifica_login.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Indicadores - INAS</title>
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
            $('#objetivos').DataTable();
        });
        function alterar(id, nome, unidade) {
            $('#id_indicador').val(id);
            $('#nome').val(nome);
            $('#unidade').val(unidade);
            $('#nome').focus();
        }
        function excluir(id, nome, id_objetivo) {
            $('#delete').attr('href', 'del_indicador.php?id=' + id + '&objetivo=' + id_objetivo);
            $('#excluir').text(nome);
            $('#confirm').modal({ show: true });
        }
    </script>
    <style>
        body {
            font-size: small;
        }
    </style>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_planejamento.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                include('actions/ManterObjetivo.php');
                include('actions/ManterIndicador.php');
                $manterObjetivo = new ManterObjetivo();
                $manterIndicador = new ManterIndicador();
                $id_objetivo = $_GET['id'];

                $objetivo = $manterObjetivo->getObjetivoPorId($id_objetivo);
                ?>
                <div class="container-fluid">
                    <div class="card mb-3 border-primary" style="max-width: 900px;">
                        <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
                            <div class="row">
                                <div class="col c2 ml-2">
                                    <div class="h5 mb-0 text-white font-weight-bold">Cadastros de Indicadores</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-bullseye fa-3x text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                                    <div class="mb-0"><?= $id_objetivo ?></div>
                                </div>
                                <div class="col-md-10">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Descrição:</div>
                                    <div class="mb-0"><?= $objetivo->descricao ?></div>
                                </div>
                            </div>

                            <h6 class="font-weight-bold">Indicador</h6>

                            <form id="form_indicador" action="save_indicador.php" method="post">
                                <input type="hidden" name="id_objetivo" value="<?= $id_objetivo ?>" />
                                <input type="hidden" name="id_indicador" value="<?= $id_indicador?>" />
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="nome" name="nome">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="unidade" class="col-sm-2 col-form-label">Unidade:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" id="unidade"
                                            name="unidade">
                                    </div>
                                </div>

                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-auto">
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fas fa-minus-square"></i> Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i> Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4 border-primary" style="max-width:900px">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Indicadores</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="objetivos" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center;">ID</th>
                                            <th scope="col" style="text-align: center;">Nome</th>
                                            <th scope="col" style="text-align: center;">Unidade</th>
                                            <th scope="col" style="width:50px;">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include('get_indicador.php') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                            <p>Deseja excluir o objetivo: <strong>"<span id="excluir"></span>"</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="#" type="button" class="btn btn-danger" id="delete">Excluir</a>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './rodape.php' ?>
        </div>
    </div>
</body>