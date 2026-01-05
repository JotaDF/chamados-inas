<?php

date_default_timezone_set('America/Sao_Paulo');
//Inicio
$mod = 1;
require_once('./verifica_login.php');

include_once('./actions/ManterUsuario.php');
include_once('./dto/Usuario.php');
include_once('./actions/ManterSetor.php');

$manterUsuario = new ManterUsuario();
$manterSetor = new ManterSetor();

$id = $_REQUEST['id'];
$usuario = new Usuario();
$usuario = $manterUsuario->getUsuarioPorId($id);

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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GERENTE - Gerenciador de tarefas</title>

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

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script type="text/javascript" class="init">
        function editar(op = 0, entrada, saida_almoco, volta_almoco, saida) {
            $('#editar').val(op);
            $(".editar").toggle();
            $("#entrada").val(entrada);
            $("#saida_almoco").val(saida_almoco);
            $("#volta_almoco").val(volta_almoco);
            $("#saida").val(saida);
            $(".neditar").toggle();
            $('#btn_editar').toggleClass('fa-lock fa-unlock');
        }
    </script>
    <style>
        body {
            font-size: small;
        }

        a:link {
            text-decoration: none;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include './menu.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include './top_bar.php'; ?>

                <div class="container-fluid">
                    <!-- Begin Page Content -->

                    <!-- Collapsable Form -->
                    <!-- Page Content-->
                    <div class="container px-4 px-lg-5 border-primary" id="form_usuario" style="max-width:1200px">
                        <!-- Heading Row-->
                        <div class="row gx-4 gx-lg-4 align-items-center my-5">
                            <div class="col-lg-5 text-right">
                                <?php
                                $dir = './ft/';
                                $imagem = '<i class="fa fa-user-circle fa-4x" aria-hidden="true"></i>';
                                $style = 'style=" border-radius: 10%; background-color: #ddd; height: 190px; object-fit: cover; width: 190px;"';
                                if (file_exists($dir . $usuario->id . '.jpg')) {
                                    $foto = $dir . $usuario->id . '.jpg';
                                    $imagem = '<img ' . $style . ' src="' . $foto . '" alt="Foto perfil" />';
                                } else if (file_exists($dir . $usuario->id . '.jpeg')) {
                                    $foto = $dir . $usuario->id . '.jpeg';
                                    $imagem = '<img ' . $style . ' src="' . $foto . '" alt="Foto perfil" />';
                                }
                                echo $imagem;
                                ?>
                            </div>
                            <div class="col-lg-7">
                                <strong>
                                    <h3 class="font-weight-light"><?= $usuario->nome ?></h3>
                                </strong>
                                <p> <?= $usuario->matricula ?><br />
                                    <?= $manterSetor->getSetorPorId($usuario->setor)->sigla ?><br />
                                    <?= $usuario->cargo ?><br />
                                    <?php
                                    $txt_whatsapp = str_replace('(', '', $usuario->whatsapp);
                                    $txt_whatsapp = str_replace(')', '', $txt_whatsapp);
                                    $txt_whatsapp = str_replace('-', '', $txt_whatsapp);

                                    $txt_aniversario = date('d/m', strtotime($usuario->nascimento));
                                    ?>
                                <form action="save_perfil_usuario.php" method="post">
                                    <input type="hidden" name="id" value="<?= $usuario->id ?>" />
                                    <img src="img/aniversario.svg" width="30">
                                    <span><b><?= $txt_aniversario ?></b></span>
                                    <br />
                                    <br />
                                    <img src="img/email.svg" class="ml-1" width="30">
                                    <span><a class="ml-1" href="mailto:<?= $usuario->email ?>"
                                            target="_blank"><?= $usuario->email ?></a></span>
                                    <br />
                                    <?php
                                    if (trim($usuario->whatsapp) != "") {
                                        ?>
                                        <span class="neditar"><img class="neditar" src="img/whatsapp.svg" width="37"><a
                                                href="https://api.whatsapp.com/send?phone=55<?= $txt_whatsapp ?>"
                                                target="_blank"><?= $usuario->whatsapp ?></a></span>
                                        <?php
                                    }
                                    ?>
                                    <img class="editar" src="img/whatsapp.svg" width="37" style="display: none;">
                                    <input type="text" class="editar form-control form-control-sm"
                                        style="display: none;" name="whatsapp" id="whatsapp"
                                        onkeypress="$(this).mask('(00)00000-0000');"
                                        value="<?= $usuario->whatsapp ?>" />
                                    <br />
                                    <?php
                                    if (trim($usuario->linkedin) != "") {
                                        ?>
                                        <span class="neditar"><img class="neditar" src="img/linkedin.svg" width="37"><a
                                                href="<?= $usuario->linkedin ?>"
                                                target="_blank"><?= $usuario->linkedin ?></a></span>
                                        <?php
                                    }
                                    ?>
                                    <img class="editar" src="img/linkedin.svg" width="37" style="display: none;">
                                    <input type="text" class="editar form-control form-control-sm"
                                        style="display: none;" name="linkedin" id="linkedin"
                                        value="<?= $usuario->linkedin ?>" />
                                    <br />
                                    <?php
                                    $check_sim = "";
                                    $check_nao = "";
                                    if ($usuario->aniversariantes == 1) {
                                        $check_sim = "checked";
                                        $check_nao = "";
                                    } else {
                                        $check_sim = "";
                                        $check_nao = "checked";
                                    }
                                    ?>
                                    <span class="editar" style="display: none;"><b>Exibir nos aniversáriantes do mês:
                                        </b></span>
                                    <input class="editar" style="display: none;" type="radio" id="sim"
                                        name="aniversariantes" value="1" <?= $check_sim ?>>
                                    <label class="editar" style="display: none;" for="sim">Sim</label> &nbsp;&nbsp;
                                    <input class="editar" style="display: none;" type="radio" id="nao"
                                        name="aniversariantes" value="0" <?= $check_nao ?>>
                                    <label class="editar" style="display: none;" for="nao">Não</label>
                                    <br /><br />
                                    <?php
                                    $horario = explode(";", $usuario->horario);
                                    ?>
                                    <span class="editar" style="display: none;"><b>Horarios dos turnos: </b></span>
                                    <br /><br />
                                    <div class="form-row g-3">
                                        <!-- Turno Matutino -->
                                        <div class="col-md-5 mb-3">
                                            <div class="card editar" style="display: none;">
                                                <div class="card-header py-0 text-center">
                                                    <h5>Matutino</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <!-- Entrada -->
                                                        <div class="col-6 col-md-6">
                                                            <label for="entrada" class="form-label">Entrada</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="entrada" name="entrada">
                                                        </div>

                                                        <!-- Saída Almoço -->
                                                        <div class="col-6 col-md-6">
                                                            <label for="saida_almoco" class="form-label">Saída</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="saida_almoco" name="saida_almoco">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Turno Vespertino -->
                                        <div class="col-md-5 mb-3">
                                            <div class="card editar" style="display: none;">
                                                <div class="card-header py-0 text-center">
                                                    <h5>Vespertino</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-2">
                                                        <!-- Volta Almoço -->
                                                        <div class="col-6 col-md-6">
                                                            <label for="volta_almoco" class="form-label">Entrada</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="volta_almoco" name="volta_almoco">
                                                        </div>

                                                        <!-- Saída -->
                                                        <div class="col-6 col-md-6">
                                                            <label for="saida" class="form-label">Saída</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="saida" name="saida">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="c3 ml-4 text-right">
                                        <button type="submit" class="btn btn-primary btn-sm editar "
                                            style="display: none;"><i class="fas fa-save"></i> Salvar</button>
                                    </div>
                                </form>
                                </p>
                                <?php
                                if ($usuario->id === $usuario_logado->id) {
                                    ?>
                                    <input type="hidden" id="editor" value="1" />
                                    <div class="c3 ml-4 text-right">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="editar(0,'<?= $horario[0] ?>', '<?= $horario[1] ?>', '<?= $horario[2] ?>', '<?= $horario[3] ?>'); this.style.display='none';"
                                            title="Editar minhas informações" style="cursor: pointer;">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>



                        <!-- Call to Action-->
                        <?php
                        if ($usuario->id === $usuario_logado->id) {
                            ?>
                            <div class="row" style="justify-content: center;">
                                <div class="ml-3 mr-3 card shadow mb-4" style="width:100%;">
                                    <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                        <div class="col-sm ml-0" style="max-width:50px;">
                                            <i class="fa fa-file-pdf fa-2x text-white"></i>
                                        </div>
                                        <div class="col mb-0">
                                            <span style="align:left;" class="h5 m-0 font-weight text-white">Folhas de
                                                ponto</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <table id="folha_ponto"
                                            class="table-sm table-striped table-bordered dt-responsive nowrap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ANO</th>
                                                    <th scope="col">MÊS</th>
                                                    <th scope="col" class="text-center">LINK</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fila">
                                                <?php include './get_folhas_ponto.php'; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="card shadow-sm mb-3" style="max-width: 300px;">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">📅 Folha de Dezembro / 2025</h5>

                                    <a class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" target="_blank"
                                        href="./folha_ponto.php?id=<?= $usuario_logado->id ?>&ano=2025&numero_mes=12&nome_mes=Dezembro"
                                        title="Abrir folha de ponto de Dezembro">
                                        <i class="fa fa-clock text-white"></i>
                                        <span>Abrir</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <?php

                                include_once('actions/ManterTarefa.php');
                                $mTarefa = new ManterTarefa();

                                $tarefas_responsavel = $mTarefa->listar(" WHERE t.id_responsavel=" . $usuario_logado->id);
                                $tarefas_criador = $mTarefa->listar(" WHERE t.id_criador=" . $usuario_logado->id);

                                $painel = $mTarefa->getPainelTarefa($usuario_logado);
                                $painel_concluidas = $mTarefa->getPainelTarefaConcluidas($usuario_logado);

                                if ($painel->total_responsavel > 0 || $painel->total_criador) {

                                    $listar = isset($_REQUEST['listar']) ? $_REQUEST['listar'] : 'pendentes';
                                    $txt_extra_titulo = "<small>(Todas)</small>";
                                    switch ($listar) {
                                        case 'pendentes':
                                            $txt_extra_titulo = "<small>(Pendentes)</small>";
                                            break;
                                        case 'concluidas':
                                            $txt_extra_titulo = "<small>(Concluídas)</small>";
                                            break;
                                    }
                                    ?>
                                    <!-- Project Card Example -->
                                    <div class="ml-3 mr-3 card shadow mb-4 " style="width: 100%">
                                        <div class="row card-header py-2 card-body bg-gradient-primary align-middle ml-0"
                                            style="width:100%">
                                            <span class="h5 m-0 font-weight text-white"></span>
                                            <div class="col-sm ml-0" style="max-width:50px;">
                                                <i class="fa fa-tasks fa-lg text-white"></i>
                                            </div>
                                            <div class="col mb-0">
                                                <span style="align:left;" class="h6 m-0 font-weight text-white">Tarefas
                                                    Importantes <?= $txt_extra_titulo ?> </span>
                                            </div>
                                            <div class="col text-right" style="min-width:60%">
                                                <a class="btn btn-outline-light btn-sm"
                                                    href="perfil_usuario.php?id=<?= $usuario_logado->id ?>&listar=todas&categoria=">
                                                    <i class="fa fa-bars" aria-hidden="true"></i> Todas
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </a>

                                                <a class="btn btn-outline-light btn-sm"
                                                    href="perfil_usuario.php?id=<?= $usuario_logado->id ?>&listar=pendentes&categoria=">
                                                    <i class="fa fa-minus-square" aria-hidden="true"></i> Pendentes
                                                </a>

                                                <a class="btn btn-outline-light btn-sm"
                                                    href="perfil_usuario.php?id=<?= $usuario_logado->id ?>&listar=concluidas&categoria=">
                                                    <i class="fa fa-check-square" aria-hidden="true"></i> Concluídas
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                        if ($painel->total_responsavel > 0) {
                                            ?>
                                            <div class="row ml-4 my-2 mr-3 border-bottom border-dark">
                                                <span class="float-right">
                                                    <a class="btn btn-sm" data-toggle="collapse" href="#collapseTarefasAtribuidas"
                                                        role="button" aria-expanded="false"
                                                        aria-controls="collapseTarefasAtribuidas">
                                                        <i class="fa fa-tasks fa-lg"></i> <strong> Atribuídas a mim</strong>
                                                    </a>
                                                </span>

                                            </div>

                                            <div class="collapse show" id="collapseTarefasAtribuidas">
                                                <div class="card-body card-deck">
                                                    <?php
                                                    $contx = 0;
                                                    foreach ($tarefas_responsavel as $obj) {
                                                        $percentual = round($mTarefa->getPercentualTarefaPorId($obj->id), 1);
                                                        $islistar = true;
                                                        switch ($listar) {
                                                            case 'pendentes':
                                                                $islistar = ($percentual < 100);
                                                                break;
                                                            case 'concluidas':
                                                                $islistar = ($percentual == 100);
                                                                break;
                                                        }
                                                        if ($islistar) {
                                                            $bg_progress = "bg-success";
                                                            if ($percentual <= 50.0) {
                                                                $bg_progress = "bg-danger";
                                                            } else if ($percentual > 50.0 && $percentual <= 99.0) {
                                                                $bg_progress = "bg-warning";
                                                            }
                                                            $txt_extra = "Início: " . date('d/m/Y', strtotime($obj->inicio)) . " Fim: " . date('d/m/Y', strtotime($obj->fim));
                                                            if ($contx == 3) {
                                                                $contx = 0;
                                                                echo "</div> <div class='card-body card-deck'>";
                                                            }
                                                            $contx++;
                                                            ?>
                                                            <div class="card text-white bg-gradient-primary mb-3" style="max-width: 18rem;">
                                                                <div class="card-header"><span class="float-right"><a
                                                                            href='gerenciar_etapas.php?tarefa=<?= $obj->id ?>'
                                                                            class='badge text-white' title='Gerenciar etapa'><i
                                                                                class='fa fa-cog fa-2x'></i></a></span><strong><?= $obj->nome ?></strong>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="card-text"><?= $obj->descricao ?>
                                                                        <br /><br /><?= $txt_extra ?>
                                                                    </p>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress mb-3">
                                                                        <div class="progress-bar <?= $bg_progress ?>" role="progressbar"
                                                                            style="width: <?= $percentual ?>%" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100"><?= $percentual ?>%</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if ($painel->total_criador > 0) {
                                            ?>

                                            <div class="row ml-4 my-0 mr-3 border-bottom border-dark">
                                                <span class="float-right">
                                                    <a class="btn btn-sm" data-toggle="collapse" href="#collapseMinhasTarefas"
                                                        role="button" aria-expanded="false" aria-controls="collapseMinhasTarefas">
                                                        <i class="fa fa-tasks fa-lg"></i> <strong> Minhas tarefas </strong>
                                                    </a>
                                                </span>

                                            </div>
                                            <div class="collapse" id="collapseMinhasTarefas">
                                                <div class="card-body card-deck">
                                                    <?php
                                                    $contx = 0;
                                                    foreach ($tarefas_criador as $obj) {
                                                        $percentual = round($mTarefa->getPercentualTarefaPorId($obj->id), 1);
                                                        $islistar = true;
                                                        switch ($listar) {
                                                            case 'pendentes':
                                                                $islistar = ($percentual < 100);
                                                                break;
                                                            case 'concluidas':
                                                                $islistar = ($percentual == 100);
                                                                break;
                                                        }
                                                        if ($islistar) {
                                                            $bg_progress = "bg-success";
                                                            if ($percentual <= 50.0) {
                                                                $bg_progress = "bg-danger";
                                                            } else if ($percentual > 50.0 && $percentual <= 99.0) {
                                                                $bg_progress = "bg-warning";
                                                            }
                                                            $txt_extra = "Início: " . date('d/m/Y', strtotime($obj->inicio)) . " Fim: " . date('d/m/Y', strtotime($obj->fim));
                                                            if ($contx == 3) {
                                                                $contx = 0;
                                                                echo "</div> <div class='card-body card-deck'>";
                                                            }
                                                            $contx++;
                                                            ?>
                                                            <div class="card text-white bg-gradient-primary mb-3" style="max-width: 18rem;">
                                                                <div class="card-header"><span class="float-right"><a
                                                                            href='gerenciar_etapas.php?tarefa=<?= $obj->id ?>'
                                                                            class='badge text-white' title='Gerenciar etapa'><i
                                                                                class='fa fa-cog fa-2x'></i></a></span><strong><?= $obj->nome ?></strong>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="card-text"><?= $obj->descricao ?>
                                                                        <br /><br /><?= $txt_extra ?>
                                                                    </p>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="progress mb-3">
                                                                        <div class="progress-bar <?= $bg_progress ?>" role="progressbar"
                                                                            style="width: <?= $percentual ?>%" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100"><?= $percentual ?>%</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
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
    <!-- Modal excluir -->
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
                    <p>Deseja excluir <strong>"<span id="nome_excluir"></span>"</strong>?</p>
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