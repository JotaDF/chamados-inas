<?php
header('Content-Type: application/json');
include("actions/ManterAtendimentoPericia.php");
$data_agendada = $_GET['data_agendada'];
$hora_agendada = $_GET['hora_agendada'];
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$resultado = $manterAtendimentoPericia->getAtendimentoPorDataEHora($data_agendada, $hora_agendada);


echo json_encode($resultado);