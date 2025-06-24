<?php
include './dto/Objetivo.php';
include_once './actions/ManterObjetivo.php';
$db_objetivo = new ManterObjetivo;
$o           = new Objetivo;

$id_planejamento = isset($_POST['id_planejamento']) ? $_POST['id_planejamento'] : 0;
$id_objetivo = isset($_POST['id_objetivo']) ? $_POST['id_objetivo'] : 0;

$o->id           = $id_objetivo; 
$o->planejamento = $id_planejamento;
$o->descricao    = html_entity_decode($_POST['descricao']);

$resultado = $db_objetivo->salvar($o);

if ($resultado) {
    header('Location: objetivo.php?id=' . $id_planejamento);
} else {
    echo 'oi';
}