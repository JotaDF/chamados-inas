<?php 
require_once('./actions/ManterTipoTarefa.php');
require_once('./dto/TipoTarefa.php');
$db_tipo_tarefa = new ManterTipoTarefa();
$t = new TipoTarefa();

$t->id   = $_POST['id'] ?? 0;
$t->nome = $_POST['nome'];
$resultado = $db_tipo_tarefa->salvar($t);

if($resultado) {
    header('Location: tipo_tarefa.php');
} else {
    header('Location: tipo_tarefa.php');
}