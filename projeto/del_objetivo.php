<?php 
require_once 'actions/ManterObjetivo.php';
$db_objetivo = new ManterObjetivo;


$id_objetivo = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$id_planejamento = isset($_REQUEST['planejamento']) ? $_REQUEST['planejamento'] : 0;
$resultado = $db_objetivo->excluir($id_objetivo);
if ($resultado) {
    header('Location: objetivo.php?id=' . $id_planejamento);
}