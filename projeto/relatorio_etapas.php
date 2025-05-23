<?php
//Gerente
$mod = 3;
require_once('./verifica_login.php');
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
    <script type="text/javascript" class="init">

        var equipes = [];
        var perfis = [];
        var editores = [];
        var naoEditores = [];
        <?php
        include_once('actions/ManterUsuario.php');
        $manterUsuario = new ManterUsuario();

        $listaNaoEditores = $manterUsuario->getNaoEditoresPorTarefa($_REQUEST['tarefa']);
        $listaEditores = $manterUsuario->getEditoresPorTarefa($_REQUEST['tarefa']);

        $txt_editores = "";
        $logadoIsEditor = false;
        foreach ($listaEditores as $obj) {
            if ($usuario_logado->id == $obj->id) {
                $logadoIsEditor = true;
            }
            if ($txt_editores === "") {
                $txt_editores = $obj->nome . " <a class='editar' href='save_editores_tarefa.php?op=del&id=" . $obj->id . "&tarefa=" . $_REQUEST['tarefa'] . "' ><i class='text-danger far fa-trash-alt'></i></a>";
            } else {
                $txt_editores .= "<br/> " . $obj->nome . " <a class='editar' href='save_editores_tarefa.php?op=del&id=" . $obj->id . "&tarefa=" . $_REQUEST['tarefa'] . "' ><i class='text-danger far fa-trash-alt'></i></a>";
            }

            ?>item = { id: "<?= $obj->id ?>", nome: "<?= $obj->nome ?>" };
            editores.push(item);
            <?php
        }

        foreach ($listaNaoEditores as $obj) {
            ?>item2 = { id: "<?= $obj->id ?>", nome: "<?= $obj->nome ?>", equipe: "<?= $obj->equipe ?>" };
            naoEditores.push(item2);
            <?php
        }
        ?>

        function mostrarEtapa(id, mostrar) {
            jQuery.post('altera_mostrar_etapa.php',
                { id: id, mostrar: mostrar }, function (res) {
                    if (res) {
                        //window.location.reload();
                    }
                });
        } 
        function carregaEditoresIncluir() {
            var html = '<option value="">Selecione </option>';
            console.log(naoEditores);
            for (var i = 0; i < naoEditores.length; i++) {
                var option = naoEditores[i];
                html += '<option value="' + option.id + '">' + option.nome + '</option>';
            }
            $('#editores_incluir').html(html);
        }

        $(document).ready(function () {

            editar(<?= $_SESSION['editar'] ?>);
            carregaEditoresIncluir();
        });

    </script>
    <style>
        body {
            font-size: small;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php
                include_once('actions/ManterEquipe.php');
                include_once('actions/ManterUsuario.php');
                include_once('actions/ManterTarefa.php');
                include_once('actions/ManterAcao.php');

                $manterAcao = new ManterAcao();
                $manterEquipe = new ManterEquipe();
                $manterUsuario = new ManterUsuario();
                $manterTarefa = new ManterTarefa();

                if (isset($_REQUEST['tarefa'])) {
                    $id_tarefa = $_REQUEST['tarefa'];
                    $tarefa = $manterTarefa->getTarefaPorId($id_tarefa);
                    $percentual = round($manterTarefa->getPercentualTarefaPorId($id_tarefa), 1);
                    //Usada para somar a quantidade de dias e calcular a data prevista das açoes
                    $data_base = $manterAcao->subitrair_dias_uteis($tarefa->inicio, $tarefa->total_dias);
                    $editar = false;
                    // Administrador ou criador ou editor
                    if ($usuario_logado->perfil == 1 || $usuario_logado->id == $tarefa->criador || $logadoIsEditor) {
                        $editar = true;
                    }

                    $executar = false;
                    // Administrador e Gerente
                    if ($usuario_logado->perfil <= 2 || $usuario_logado->id == $tarefa->responsavel) {
                        $executar = true;
                    }
                    ?>
                    <div class="container-fluid">
                        <!-- Exibe dados da  tarefa -->
                        <div class="card mb-3" style="max-width: 100%; border-color: #949494">
                            <div class="card-body text-dark" style="min-height: 2.0rem; background-color: #d3d3d3;">
                                <div class="row">
                                    <div class="col c2 ml-2">
                                        <div class="h6 text-xs text-dark font-weight-bold text-uppercase mb-1">
                                            <?= $tarefa->categoria ?></div>
                                        <div class="h5 mb-0 text-dark font-weight-bold">[<small><?= $tarefa->id ?></small>]
                                            <?= $tarefa->nome ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-tasks fa-3x text-dark"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="c1 ml-4">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Início</div>
                                        <div class="mb-0"><?= date('d/m/Y', strtotime($tarefa->inicio)) ?></div>
                                    </div>
                                    <div class="c2 ml-4">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Fim</div>
                                        <div class="mb-0"><?= date('d/m/Y', strtotime($tarefa->fim)) ?></div>
                                    </div>
                                    <?php
                                    if ($editar) {
                                        echo '<input type="hidden" id="editor" value="1"/><input type="hidden" id="op" value="1"/>';
                                        ?>
                                        <div class="c3 ml-4 text-right">
                                            
                                        </div>
                                        <?php
                                    } 
                                    ?>
                                </div>
                                <h6 class="mt-3 ml-2 card-title">Descrição</h6>
                                <p class=" ml-2 card-text"><?= $tarefa->descricao ?></p>
                                <div class="row">
                                    <div class="c0 ml-4 mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"><small
                                                class="text-muted">Criador</small></div>
                                        <div class="mb-0"><small
                                                class="text-muted"><?= ($tarefa->criador > 0 ? $manterUsuario->getUsuarioPorId($tarefa->criador)->nome : '') ?></small>
                                        </div>
                                    </div>
                                    <div class="c1 ml-5">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"><small
                                                class="text-muted">Equipe</small></div>
                                        <div class="mb-0"><small
                                                class="text-muted"><?= ($tarefa->equipe > 0 ? $manterEquipe->getEquipePorId($tarefa->equipe)->equipe : 'Pessoal') ?></small>
                                        </div>
                                    </div>
                                    <div class="c2 ml-5">
                                        <div class="text-xs font-weight-bold  text-uppercase mb-1"><small
                                                class="text-muted">Responsável</small></div>
                                        <div class="mb-0"><small
                                                class="text-muted"><?= ($tarefa->responsavel > 0 ? $manterUsuario->getUsuarioPorId($tarefa->responsavel)->nome : '') ?></small>
                                        </div>
                                    </div>



                                    <div class="c3 ml-5">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1"><small
                                                class="text-muted">Tipo</small></div>
                                        <div class="mb-0"><small class="text-muted"><?= $tarefa->tipo ?></small></div>
                                    </div>
                                </div>
                                <div class="mt-2 progress">
                                    <div id="progressbar" class="progress-bar bg-success" role="progressbar"
                                        style="width: <?= $percentual ?>%;" aria-valuenow="<?= $percentual ?>"
                                        aria-valuemin="0" aria-valuemax="100"><?= $percentual ?>%</div>
                                </div>
                            </div>
                        </div>
                        <!-- fim da exibição -->
                        <?php
                }
                ?>


                    <!-- ETAPAS -->
                    <?php include './get_etapa_relatorio.php'; ?>
                    <!-- FIM ETAPAS -->
                </div>
                <!-- End of Main Content -->
                <?php include './rodape.php'; ?>
            </div>

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