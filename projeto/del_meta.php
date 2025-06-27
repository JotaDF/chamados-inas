<?php 
require_once 'actions/ManterMeta.php';
$db_meta = new ManterMeta;


$id_meta       = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$id_indicador  = isset($_REQUEST['indicador']) ? $_REQUEST['indicador'] : 0;
$resultado     = $db_meta->excluir($id_meta);
if ($resultado) {
    header('Location: meta.php?id=' . $id_indicador);
}