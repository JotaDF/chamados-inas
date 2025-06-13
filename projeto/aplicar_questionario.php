<?php
// $mod = 16;
//  require_once 'quest_aceite.php';
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário - INAS</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" class="init">
    </script>
    <style>
        body {
            /* Light gray background */
            font-size: small;
        }

        .card {
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-check-label {
            margin-left: 5px;
            /* Espaçamento entre o radio/checkbox e o texto */
        }

        .form-label {
            font-weight: 20px;
            font-size: 15px;
            color: #343a40;
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
                require_once 'actions/ManterQuestAplicacao.php';
                include_once('actions/ManterQuestQuestionario.php');
                include_once('actions/ManterQuestEscala.php');
                include_once('actions/ManterQuestEscala.php');
                include_once('actions/ManterPergunta.php');
                $manterQuestAplicacao = new ManterQuestAplicacao();
                $manterQuestQuestionario = new ManterQuestQuestionario();
                $manterQuestEscala = new ManterQuestEscala();
                if(isset($_GET['id']) && isset($_GET['aplicacao'])) {
                $id_questionario        = (int) $_GET['id'];
                $id_quest_aplicacao     = (int) $_GET['aplicacao']; 
            }
                if ($id_questionario) {
                $questionario = $manterQuestQuestionario->getQuestionarioPorId($id_questionario);
    
                if (!$questionario) {
                    echo "<p class='alert alert-warning text-center'>Questionário não encontrado.</p>";
                    exit();
                }
                $todas_perguntas = $manterQuestAplicacao->getTodasPerguntasPorQuestionario($id_questionario); 
                $categoria_atual = null;
                $numero_pergunta = 1;
    ?>
    <div class="container-fluid">
         <div id="content-wrapper" class="d-flex flex-column">
             <div class="card container border-dark">
            <div class="text-center mb-4">
                <img src="img/logo_oficial.png" alt="" style="width: 400px;">
            </div>
        <div class="card-header py-2 border border-dark rounded mb-2 text-dark" style="background-color: #dee2e6;">
            <h5 class="mb-2"><?= $questionario->titulo ?? 'Título do Questionário' ?></h5>
            <br>
            <p class="fs-3 mb-2"><?= $questionario->descricao ?? 'Descrição do questionário' ?></p>
        </div>
            <div class="card-body p-2">
                <form action="processa_quest_resposta.php" method="POST">
                    <input type="hidden"  name="id_usuario"          value="<?= $usuario_logado->id ?>">
                    <input type="hidden"  name="id_questionario"     value="<?= $id_questionario ?>">
                    <input type="hidden"  name="id_quest_aplicacao"  value="<?= $id_quest_aplicacao?>">
 
                    <?php
                    foreach ($todas_perguntas as $pergunta) {
                        if ($pergunta->nome_categoria !== $categoria_atual) {
                            
                            if ($categoria_atual !== null) {
                                echo '</div>'; 
                            }
                            $categoria_atual                = $pergunta->nome_categoria;
                            ?>
                                <div class="card-header py-1 border border-dark rounded mb-1" style="background-color: #f8f9fa;">
                                    <h5 class="text-left ">
                                        <p> <?= $categoria_atual ?> </p>
                                    </h5>
                                </div>
                            <div class="mb-2 p-1 bg-white"> 
                            <?php
                        }
                        $opcional      = ($pergunta->opcional == 0) ? "required" : ""; 
                        $tag_required  = ($opcional === 'required') ? "<span class='text-danger'> * </span>" : "";
                        ?>
                        <div class="mb-3 border border-dark rounded p-2">
                            <label class="form-label fw-bold mb-2 ">
                                <?php 
                                echo "<strong>" . $numero_pergunta++ . ". "; 
                                echo  ($pergunta->pergunta) . "</strong>"; 
                                echo $tag_required; 
                                ?>
                            </label> 
                            
                            <?php if ($pergunta->parametro_escala != 'livre') { 
                                $opcoes = explode(';', $pergunta->parametro_escala);
                                ?>
                                <div class="d-flex flex-wrap gap-3">
                                    <?php 
                                    $primeiro_radio = true; 
                                    foreach ($opcoes as $opcao) {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input 
                                                class="form-check-input" type="radio" name="resposta_<?= $pergunta->id ?>" 
                                                id="<?= $pergunta->id ?>_<?= $opcao ?>" 
                                                value="<?= $opcao ?>"
                                                <?= $primeiro_radio ? $opcional : '' ?> 
                                            >
                                            <label class="form-check-label" for="resposta_<?= $pergunta->id ?>_<?=$opcao ?>">
                                                <?= $opcao ?>
                                            </label>
                                        </div>
                                    <?php 
                                        $primeiro_radio = false; 
                                } 
                                    ?>
                                </div>

                            <?php  } else { // Usando nome_escala aqui ?>
                                <input 
                                    type="text" class="form-control form-control-sm" name="resposta_<?= $pergunta->id ?>" id="resposta_<?= $pergunta->id ?>_texto"  placeholder="<?= $pergunta->titulo ?? 'Digite sua resposta aqui...' ?>"
                                    <?= $opcional ?> 
                                >
                            <?php } ?>
                        </div> 
                    <?php } // Fim do foreach ($todas_perguntas) ?>
                    
                    <?php 
                    // Fecha o último div de categoria, se houver perguntas
                    if ($categoria_atual !== null) {
                        echo '</div>'; 
                    }
                    ?>

                    <div class="d-grid gap-1 mt-2">
                        <button type="submit" class="btn btn-outline-primary btn-sm">Enviar Questionário</button>
                    </div>
                </form>
            </div>
            </div>
            <?php
    } else {
        echo "<p class='alert alert-danger text-center mt-5'>ID do questionário não fornecido.</p>";
    }
                    ?>

                        </form>
                    </div>

                    <?php ?>
                </div>
                </div>
            </div>
        </div>
</body>

</html>