<?php

require_once('./actions/ManterCartaRecurso.php');

$db_carta_recurso = new ManterCartaRecurso();

$ids = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_carta_recurso->atestarLote($ids);
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
