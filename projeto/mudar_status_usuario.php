<?php

require_once('./actions/ManterUsuario.php');

$db_usuario = new ManterUsuario();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
if ($id > 0) {
    if ($status == 0) {
        $db_usuario->desativar($id);
    } else {
        $db_usuario->ativar($id);
    }
    header('Location: usuarios.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: usuarios.php');
}
