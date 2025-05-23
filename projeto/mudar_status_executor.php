<?php

require_once('./actions/ManterPrestador.php');

$db_prestador = new ManterPrestador();

$id_usuario = isset($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 0;
$id_prestador = isset($_REQUEST['id_prestador']) ? $_REQUEST['id_prestador'] : 0;
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;

if ($id_usuario > 0) {
    if ($status == 0) {
        $db_prestador->desativarExecutor($id_prestador,$id_usuario);
    } else {
        $db_prestador->ativarExecutor($id_prestador,$id_usuario);
    }
    header('Location: gerenciar_executor_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_executor_prestador.php?id='.$id_prestador);
}
