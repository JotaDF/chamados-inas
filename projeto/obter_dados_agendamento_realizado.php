<?php
header('Content-Type: application/json');
include("actions/ManterAtendimentoPericia.php");
$id = $_GET['id'];
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$resultado = $manterAtendimentoPericia->listaAtendimentoRealizadoPorId($id);


echo json_encode($resultado);