<?php
header('Content-Type: application/json');
include("actions/ManterAtendimentoPericia.php");
$id_fila = $_GET['id_fila'];
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$resultado = $manterAtendimentoPericia->listaAtendimentoRealizadoPorId($id_fila);


echo json_encode($resultado);