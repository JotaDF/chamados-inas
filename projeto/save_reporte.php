<?php 
require_once('actions/ManterReporte.php');
require_once('dto/Reporte.php');

$id_reporte   = isset($_POST['id_reporte']) ? $_POST['id_reporte'] : 0;
$id_projeto   = isset($_POST['id_projeto']) ? $_POST['id_projeto'] : 0;
$id_indicador = isset($_POST['indicador']) ? $_POST['indicador'] : 0;
$conteudo     = isset($_POST['conteudo']) ? $_POST['conteudo'] : '';
$tipo         = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$p             = new Reporte();

$p->id         = $id_reporte;
$p->conteudo   = $conteudo;
$p->tipo       = $tipo;
$p->projeto    = $id_projeto;
$p->indicador  = $id_indicador;
$db_reporte    = new ManterReporte();
$resultado     = $db_reporte->salvar($p);

if($resultado) {
    header('Location: reporte.php?id=' . $id_projeto);
    exit();
} else {
    echo 'falta parametro!';
    header('Location: reporte.php?id=' . $id_projeto);
    exit();
}