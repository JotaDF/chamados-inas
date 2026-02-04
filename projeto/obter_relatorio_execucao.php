<?php
require_once('actions/ManterPrestador.php');
header('Content-Type: application/json; charset=utf-8');
$manterPrestador = new ManterPrestador();
$competencia = $_GET['competencia'];


if ($competencia == "todas") {
    $anos_competencia = $_GET['ano_competencia'];
    echo json_encode($manterPrestador->getMaioresValoresPorCompetencia($anos_competencia));
}
if ($competencia != "todas") {
    $quantidade_exibicao = $_GET['quantidade_exibicao'];
    echo json_encode($manterPrestador->getPrestadoresMaioresValoresPorCompetencia($competencia, $quantidade_exibicao));
}



