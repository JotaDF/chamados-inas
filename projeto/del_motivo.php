<?php

require_once('./actions/ManterMotivo.php');
require_once('./dto/Motivo.php');

$db_motivo = new ManterMotivo();
$motivo= new Motivo();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_motivo->excluir($id);
    header('Location: motivos.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: motivos.php');
}
