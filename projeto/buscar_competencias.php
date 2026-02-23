<?php
require_once('actions/ManterPagamento.php');
require_once('actions/ManterCartaRecurso.php');
header('Content-Type: application/json;');

$manterPagamento = new ManterPagamento();
$manterCartaRecurso = new ManterCartaRecurso();
$ano = $_POST['ano'];
$tipo = $_POST['tipo'];
$adm = $_POST['adm'];
$dados = [];

if ($adm != '1') {
    $dados = $tipo == 'pagamento' 
    ? $manterPagamento->getCompetenciasNaoAdministrativasPorAno($ano)
    : $manterCartaRecurso->getCompetenciasNaoAdministrativasPorAno($ano);
}

if ($adm == '1') {
    $dados = $tipo == 'pagamento' 
    ? $manterPagamento->getCompetenciasAdministrativasPorAno($ano)
    : $manterCartaRecurso->getCompetenciasAdministrativasPorAno($ano);
}



echo json_encode($dados);

