<?php
require_once('actions/ManterReporte.php');

$id_reporte = isset($_GET['id']) ? $_GET['id'] : 0;
$id_projeto = isset($_GET['id_projeto']) ? $_GET['id_projeto'] : 0;
$db_reporte = new ManterReporte();
$resultado = $db_reporte->excluir($id_reporte);
if($resultado) {
    header('Location: reporte.php?id=' . $id_projeto);
    exit();
} else {
    header('Location: reporte.php?id=' . $id_projeto);
    exit();
}