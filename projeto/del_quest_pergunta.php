<?php
require_once './actions/ManterQuestPergunta.php';

if ($_SERVER['REQUEST_METHOD']) {
    $id  =  $_REQUEST['id'] ? $_REQUEST['id'] : 0;

    $manterQuestPergunta = new ManterQuestPergunta();

    if ($id > 0) {
        $manterQuestPergunta->excluir($id);
        header('Location: quest_pergunta.php?msg=10');
        exit;
    }
} 