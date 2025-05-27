<?php

require_once('./actions/ManterQuestAplicacao.php');

$manterQuestAplicacao = new ManterQuestAplicacao();

$id =                isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$id_quesitonario =   isset($_REQUEST['id_questionario']) ? $_REQUEST['id_questionario'] : 0;
$publicado =         isset($_REQUEST['publicado']) ? $_REQUEST['publicado'] : 0;
if ($id > 0) { 
    if ($publicado == 0) {
        $manterQuestAplicacao->despublicar($id);
    } else {
        $manterQuestAplicacao->publicar($id);
    }
    header('Location: quest_gerenciar_aplicacoes_questionario.php?id='. $id_quesitonario);
} else {
    echo 'Falta de parâmetro!';
    header('Location: quest_gerenciar_aplicacoes_questionario.php?id='. $id_quesitonario);
}
