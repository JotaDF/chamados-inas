<?php
require_once('./actions/ManterMedicoPerito.php');
require_once('./dto/MedicoPerito.php');

$db_medico_perito = new ManterMedicoPerito();
$m = new MedicoPerito();

$id = isset($_POST['id']) ? $_POST['id'] : 0;

$m->id = $id;
$m->nome = $_POST['nome'];

$db_medico_perito->salvar($m);
header('Location: medico_perito.php');


