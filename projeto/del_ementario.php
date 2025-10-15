<?php

require_once('./actions/ManterEmentario.php');

$db_ementario = new ManterEmentario();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_ementario->excluir($id);
    header('Location: ementario.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: ementario.php');
}
