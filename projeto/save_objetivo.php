<?php
include './dto/Objetivo.php';
include_once './actions/ManterObjetivo.php';
$db_objetivo = new ManterObjetivo;
$o           = new Objetivo;

$id_planejamento = isset($_POST['id_planejamento']) ? $_POST['id_planejamento'] : 0;
$descricao       = isset($_POST['descricao']) ? $_POST['descricao'] : "";

$o->planejamento = $id_planejamento;
$o->descricao    = $descricao;

$resultado = $db_objetivo->salvar($o);

if ($resultado) {
    header('Location: objetivo.php?id=' . $id_planejamento);
}