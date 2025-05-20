<?php
require_once 'actions/ManterQuestQuestionario.php';
require_once 'dto/QuestQuestionario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = $_POST['id_quest_questionario'];
    $titulo         = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao      = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    
   
    if (!$titulo || !$descricao) {
        header('Location: quest_questionario.php?erro=1');
        exit;
    } 
    if (trim($descricao) === '') {
        header('Location: quest_questionario.php?msg=2');
        exit;
    }
    
    $questionarioDTO                = new QuestQuestionario();
    $questionarioDTO->id            = $id;
    $questionarioDTO->titulo        = $titulo;
    $questionarioDTO->descricao     = $descricao;

    $manterQuestionario             = new ManterQuestQuestionario;
    $resultado                      = $manterQuestionario->salvar($questionarioDTO);

    if($resultado) {
        header('Location: quest_questionario.php?msg=1');
        exit;
    }
}