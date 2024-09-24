<?php

require_once('./actions/ManterNotaGlosa.php');

$db_nota_glosa = new ManterNotaGlosa();

$ids = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_nota_glosa->atestar($ids);
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
