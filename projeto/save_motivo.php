<?php

require_once('./actions/ManterMotivo.php');
require_once('./dto/Motivo.php');

$db_motivo = new ManterMotivo();
$s = new Motivo();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$motivo = $_POST['motivo'];

$s->id = $id;
$s->motivo = $motivo;

$db_motivo->salvar($s);
header('Location: motivos.php');

