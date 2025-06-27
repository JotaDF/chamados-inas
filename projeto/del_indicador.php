<?php 
require_once 'actions/ManterIndicador.php';
$db_indicador = new ManterIndicador;


$id_objetivo = isset($_REQUEST['objetivo']) ? $_REQUEST['objetivo'] : 0;
$id_indicador = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$resultado = $db_indicador->excluir($id_indicador);
if ($resultado) {
    header('Location: indicador.php?id=' . $id_objetivo);
}