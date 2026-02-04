<?php
require_once('actions/ManterPagamento.php');
header('Content-Type: application/json;');

$manterPagamento = new ManterPagamento();
$ano = $_POST['ano'];

echo json_encode($manterPagamento->getCompetenciasNaoAdministrativasPorAno($ano));

