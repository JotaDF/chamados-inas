<?php
require_once('actions/ManterFeriadoAno.php');
require_once('dto/FeriadoAno.php');

$id_feriado = $_POST['id'] ?? "";
$data       = $_POST['data'];
$descricao  = $_POST['descricao'];
$f = new FeriadoAno();
$f->id   = $id_feriado;
$f->data = $data;
$f->descricao = $descricao ;
$db_feriado = new ManterFeriadoAno();

$resultado = $db_feriado->salvar($f);

if($resultado) {
    header('Location: feriados.php');
} 