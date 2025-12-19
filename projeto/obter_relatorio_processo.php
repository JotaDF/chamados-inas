<?php
require_once('actions/ManterProcesso.php');
header('Content-Type: application/json; charset=utf-8');
$ano = $_GET['ano'];
$tipo= $_GET['tipo'];
$arquivado= $_GET['arquivado'];
$manterProcesso = new ManterProcesso();
$dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado);
echo json_encode($dados);

