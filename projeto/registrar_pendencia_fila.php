<?php 
include ('actions/ManterFilaPericiaEco.php');
$db_fila_pericia_eco = new ManterFilaPericiaEco();
$id_fila = $_POST['id_fila'];
$pendencia = $_POST['pendencia'];

$resultado = $db_fila_pericia_eco->registraPendencia($id_fila, $pendencia);

header('Location: fila_pericia_eco.php');

