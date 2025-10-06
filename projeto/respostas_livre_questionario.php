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
                include_once('actions/ManterQuestResposta.php');
                include_once('actions/ManterQuestPergunta.php');
                $id_questionario = $_GET['quest'];
                $id_pergunta = $_GET['id'];
                $manterQuestResposta = new ManterQuestResposta();
                $manterQuestPergunta = new ManterQuestPergunta();
                $pergunta = $manterQuestPergunta->getPerguntaPorId($id_pergunta);
                $resposta = $manterQuestResposta->getRespostaLivrePorIdQuestionario($id_questionario, $id_pergunta);
                ?>
                <div class="container-fluid d-flex justify-content-center mt-4">
                    <div class="card border-primary shadow-sm" style="max-width: 1000px; width: 100%;">
                        <div class="card-body">
                            <!-- Cabeçalho da pergunta -->
                            <div
                                class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3">
                                <h5 class="font-weight-bold text-dark mb-2 mb-md-0">
                                    <?= $pergunta ?>
                                </h5>
                                <p class="mb-0 text-dark" style="font-size: 16px;">
                                    <strong>Total de respostas:</strong> <?= count($resposta) ?>
                                </p>
                            </div>

                            <!-- Lista de respostas -->
                            <?php foreach ($resposta as $rp){ ?>
                                <div class="rounded p-2 mb-1 bg-light text-dark">
                                    <p class="mb-0" style="font-size: 14px;">
                                        <b><?= $rp->resposta ?></b>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


            </div>
            <?php include './rodape.php'; ?>
        </div>
    </div>
</body>