<?php
require_once './actions/ManterQuestQuestionario.php';

if ($_SERVER['REQUEST_METHOD']) {
    $id  =  $_REQUEST['id'] ? $_REQUEST['id'] : 0;

    $manterQuestQuestionario = new ManterQuestQuestionario();

    if ($id > 0) {
        $manterQuestQuestionario->excluir($id);
        header('Location: quest_questionario.php?msg=10');
        exit;
    }
} 