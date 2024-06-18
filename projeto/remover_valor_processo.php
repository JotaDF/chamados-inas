<?php

require_once('./actions/ManterValorProcesso.php');

$db_valor_processo = new ManterValorProcesso();

$id = $_REQUEST['id'];
$id_processo = $_REQUEST['id_processo'];
if ($id > 0) {
    $db_valor_processo->excluir($id);
    header('Location: gerenciar_valores_processo.php?id='.$id_processo);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_valores_processo.php?id='.$id_processo);
}
