<?php
require_once('actions/ManterProcesso.php');
header('Content-Type: application/json; charset=utf-8');
$ano = $_GET['ano'];
$tipo= $_GET['tipo'];
$manterProcesso = new ManterProcesso();
$dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano);
echo json_encode($dados);

