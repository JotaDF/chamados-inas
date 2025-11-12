<?php
require_once('./actions/ManterMedicoPerito.php');
require_once('./dto/MedicoPerito.php');

$db_medico_perito = new ManterMedicoPerito();

$m = new MedicoPerito();

$id = $_REQUEST['id'];

$resultado = $db_medico_perito->excluir($id);
if($resultado) {
    header('Location: medico_perito.php');
} else {
    header('Location: medico_perito.php');
}
