<?php 
require_once('./actions/ManterTipoTarefa.php');
$db_tipo_tarefa = new ManterTipoTarefa();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_tipo_tarefa->excluir($id);
    header('Location: tipo_tarefa.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: tipo_tarefa.php');
}