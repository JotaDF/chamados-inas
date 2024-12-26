<?php

require_once('./actions/ManterUsuario.php');

$db_usuario = new ManterUsuario();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$ativo = isset($_REQUEST['ativo']) ? $_REQUEST['ativo'] : 0;
if ($id > 0) {
    if ($ativo == 0) {
        $db_usuario->desativar($id);
    } else {
        $db_usuario->ativar($id);
    }
    header('Location: usuarios.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: usuarios.php');
}
