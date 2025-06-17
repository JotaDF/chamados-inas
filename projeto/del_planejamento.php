<?php
require_once 'actions/ManterPlanejamento.php';
$db_planejamento = new ManterPlanejamento;


$id_planejamento = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$resultado = $db_planejamento->excluir($id_planejamento);

if ($resultado) {
    header('Location: planejamento.php');
}
