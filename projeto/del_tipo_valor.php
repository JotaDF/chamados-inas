<?php

require_once('./actions/ManterTipoValor.php');
require_once('./dto/TipoValor.php');

$db_tipo_valor = new ManterTipoValor();
$tipo_valor= new TipoValor();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_tipo_valor->excluir($id);
    header('Location: tipos_valores.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: tipos_valores.php');
}
