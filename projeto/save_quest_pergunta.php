<?php
require_once 'actions/ManterQuestPergunta.php';
require_once 'dto/QuestPergunta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id                     = isset($_POST['id_quest_pergunta']) ? $_POST['id_quest_pergunta'] : 0;
    $id_quest_escala        = $_POST['id_quest_escala'];
    $titulo                 = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $pergunta               = filter_input(INPUT_POST, 'pergunta', FILTER_SANITIZE_SPECIAL_CHARS);
    $opcional               = isset($_POST['opcional']) ? $_POST['opcional'] : 0;
    if (!$titulo || !$pergunta || !$id_quest_escala) {
        header('Location: quest_pergunta.php?error=1');
        exit();
    }

    $perguntaDTO                    = new QuestPergunta;
    $perguntaDTO->id                = $id;
    $perguntaDTO->id_quest_escala   = $id_quest_escala;
    $perguntaDTO->titulo            = $titulo;
    $perguntaDTO->pergunta          = $pergunta;
    $perguntaDTO->opcional          = $opcional;
    $manterQuestPergunta            = new ManterQuestPergunta;

    $resultado = $manterQuestPergunta->salvar($perguntaDTO);


    if ($resultado) {
        header('Location: quest_pergunta.php?msg=1');
        exit;
    } else {
        echo "deu erro";
    }
} 