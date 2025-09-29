<?php
//Questionario
$mod = 16;
require_once 'verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respostas</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <!------ Include the above in your HEAD tag ---------->

    <!-- Bootstrap CSS (repetido) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <!-- DataTables Bootstrap4 CSS (repetido) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <!-- DataTables Responsive Bootstrap4 CSS (repetido) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery 3.3.1 (NÃO SLIM, preferível para plugins) -->
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
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- jQuery 3.3.1 SLIM (NÃO recomendado junto com o jQuery completo, pode causar conflito) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        function verificaParametro(parametro) {
            if (parametro.length <= 2) return "bar";
            if (parametro.length <= 7) return "pie";
            return "radar";
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
        <?php include './menu_questionario.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                include_once('actions/ManterQuestQuestionario.php');
                include_once('actions/ManterQuestPergunta.php');
                include_once('actions/ManterQuestResposta.php');
                include_once('actions/ManterQuestEscala.php');
                include_once('actions/ManterQuestAplicacao.php');
                $manterQuestEscala = new ManterQuestEscala();
                $manterQuestPergunta = new ManterQuestPergunta();
                $manterQuestResposta = new ManterQuestResposta();
                $manterQuestQuestionario = new ManterQuestQuestionario();
                $manterQuestAplicacao = new ManterQuestAplicacao();
                $id_questionario = $_GET['id'];

                $escalas = $manterQuestEscala->listar();
                $perguntas = $manterQuestAplicacao->getTodasPerguntasPorQuestionario($id_questionario);
                $questionario = $manterQuestQuestionario->getQuestionarioPorId($id_questionario);
                $total_respostas = $manterQuestResposta->getTotalRespostaPorIdQuestionario($id_questionario);
                ?>
                <div class="container-fluid">
                    <div class="container mx-auto">
                        <div class="card mb-3 border-primary" style="max-width: 1000px;">
                            <div class="card-body">
                                <div class="row g-3 text-center">
                                    <div class="col p-3">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">ID</div>
                                        <div class="h5 font-weight-bold mb-0"><?= $questionario->id ?>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Título</div>
                                        <div class="h5 font-weight-bold mb-0"><?= $questionario->titulo ?>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Descrição</div>
                                        <div class="h5 font-weight-bold mb-0">
                                            <?= $questionario->descricao ?>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total de Respostas
                                        </div>
                                        <div class="h5 font-weight-bold mb-0"><?= $total_respostas ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($perguntas as $pergunta) {

                            $respostas_pergunta = $manterQuestResposta->getTodasRespostaPorPerguntaQuestionario($id_questionario, $pergunta->id);
                            $total_respostas_pergunta = $manterQuestResposta->getTotalRespostaPorPerguntaQuestionario($id_questionario, $pergunta->id);
                            $total_respostas_parametro = $manterQuestResposta->getTotalRespostaPorParametro($id_questionario, $pergunta->id);
                            $parametros = $manterQuestPergunta->getParametroPergunta($pergunta->id);
                            $parametros_resposta = explode(";", $parametros);
                            $escala = $manterQuestPergunta->getEscalaPorPergunta($pergunta->id);

                            if (empty($pergunta->pergunta)) {
                                ?>
                                <p class="text-muted mb-0">Nenhuma resposta disponível.</p> <?php
                            } else {
                                if ($pergunta->parametro_escala != "livre") { ?>
                                    <div class="card mb-3 border-primary" style="max-width: 1000px;">
                                        <div class="p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <!-- Pergunta -->
                                                <h5 class="font-weight-bold text-dark mb-0">
                                                    <?= $pergunta->pergunta ?>
                                                </h5>

                                                <!-- Total de respostas -->
                                                <p class="mb-0 " style="font-size: 16px;">
                                                    <strong>Total de respostas:</strong> <?= $total_respostas_pergunta ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-body " style="width: 80%;">
                                            <div style="width: 100%; max-width: 100px height: 200px; margin: 0 auto;">
                                                <canvas id="grafico_respostas<?= $pergunta->id ?>"></canvas>
                                                <?php require('dashboard_resposta_questionario.php') ?>
                                            </div>
                                            <br />
                                            </p>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="card mb-3 border-primary" style="max-width: 1000px;">
                                        <div class="p-3">
                                            <!-- Cabeçalho da pergunta -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="font-weight-bold text-dark mb-0">
                                                    <?= $pergunta->pergunta ?>
                                                </h5>
                                                <p class="mb-0" style="font-size: 16px;">
                                                    <strong>Total de respostas:</strong> <?= $total_respostas_pergunta ?>
                                                </p>
                                            </div>
                                            <?php
                                            $total_respostas = count($respostas_pergunta);
                                            $limite = 10;
                                            $exibir_respostas = array_slice($respostas_pergunta, 0, $limite);

                                            foreach ($exibir_respostas as $rp) {
                                                if (!empty($rp->resposta)) {
                                                    ?>
                                                    <div class="rounded p-2 mb-1 bg-light">
                                                        <p class="mb-0" style="font-size: 14px;">
                                                            <?= htmlspecialchars($rp->resposta) ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            // Se tiver mais de 10, mostra o link
                                            if ($total_respostas > $limite) {
                                                ?>
                                                <div class="rounded p-2 mb-1 bg-light">
                                                    <p class="mb-0" style="font-size: 14px;">
                                                        <a href="respostas_livre_questionario.php?id=<?= $pergunta->id ?>&quest=<?= $id_questionario ?>"
                                                            target="_blank" class="text-primary">Ver todas as respostas</a>
                                                    </p>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php include './rodape.php'; ?>
            </div>
        </div>
</body>

</html>