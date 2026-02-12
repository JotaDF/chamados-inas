<?php
require_once('actions/ManterPagamento.php');
require_once('actions/ManterCartaRecurso.php');
header('Content-Type: application/json;');

$manterPagamento = new ManterPagamento();
$manterCartaRecurso = new ManterCartaRecurso();
$ano = $_POST['ano'];
$tipo = $_POST['tipo'];
$dados = [];
if ($tipo == 'pagamento') {
    $dados = $manterPagamento->getCompetenciasNaoAdministrativasPorAno($ano);
}
if ($tipo == 'glosa') {
    $dados = $manterCartaRecurso->getCompetenciasNaoAdministrativasPorAno($ano);
}
echo json_encode($dados);

