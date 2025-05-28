<?php
require_once './actions/ManterQuestAplicacao.php';

if ($_SERVER['REQUEST_METHOD']) {
    $id  =  $_REQUEST['id'] ? $_REQUEST['id'] : 0;
    $id_questionario =  $_REQUEST['id_questionario'] ? $_REQUEST['id_questionario'] : 0;
    $manterQuestAplicacao = new ManterQuestAplicacao();
    if ($id > 0) {
        $manterQuestAplicacao->excluir($id);
        header('Location: quest_gerenciar_aplicacoes_questionario.php?id=' . $id_questionario);
        exit;
    }
} 