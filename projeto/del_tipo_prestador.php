<?php

require_once('./actions/ManterTipoPrestador.php');
require_once('./dto/TipoPrestador.php');

$db_tipo_prestador = new ManterTipoPrestador();
$tipo_prestador= new TipoPrestador();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_tipo_prestador->excluir($id);
    header('Location: tipos_prestador.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: tipos_prestador.php');
}
