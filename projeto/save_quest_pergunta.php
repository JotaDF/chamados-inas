<?php
require_once 'actions/ManterQuestPergunta.php';
require_once 'dto/QuestPergunta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_quest_escala                 = $_POST['id_quest_escala'];
    $titulo                          = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $pergunta                        = filter_input(INPUT_POST, 'pergunta', FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$titulo || !$pergunta || !$id_quest_escala) {
        header('Location: quest_pergunta.php?error=1');
        exit();
    }

    $perguntaDTO                                  = new QuestPergunta;
    $perguntaDTO->id_quest_escala                 = $id_quest_escala;
    $perguntaDTO->titulo                          = $titulo;
    $perguntaDTO->pergunta                        = $pergunta;
    $manterQuestPergunta = new ManterQuestPergunta;
    $resultado = $manterQuestPergunta->salvar($perguntaDTO);


    if($resultado) {
        header('Location: quest_pergunta.php?msg=1');
        exit;
    } else {
        echo "deu erro";
        echo $id_quest_escala;
    }
}