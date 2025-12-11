<?php

require_once('./actions/ManterOficio.php');

$db_oficio = new ManterOficio();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_oficio->excluir($id);
    $caminho = __DIR__.'/oficios/arquivo_'. $id .'/';
    $db_oficio->delPasta($caminho);
    header('Location: oficios.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: oficios.php');
}
