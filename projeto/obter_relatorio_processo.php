<?php
require_once('actions/ManterProcesso.php');
header('Content-Type: application/json; charset=utf-8');
// Obtém os parâmetros da requisição
$ano = $_GET['ano'];
$tipo = $_GET['tipo'];
$tipo_valor = $_GET['tipo_valor'];
$arquivado = $_GET['arquivado'];
$ordem = $_GET['ordem'];
// Cria uma instância do ManterProcesso
$manterProcesso = new ManterProcesso();
// Inicializa a variável de dados
if ($tipo == 'grafico_motivo') {
    $dados = $manterProcesso->getRelatorioTotalMotivosPorAno($ano, $arquivado, $ordem ?? 'm.motivo');
}

if ($tipo == 'grafico_assunto') {
    $dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado, $ordem ?? 'a.assunto, sa.sub_assunto');
}

if ($tipo == 'grafico_ano') {
    $dados = $manterProcesso->relatoriosPorAno();
}

if ($tipo == 'grafico_ano_mes') {
    $dados = $manterProcesso->relatorioTotaisPorMes($ano);
}

if($tipo == 'grafico_tipo_valor') {
    $dados = $manterProcesso->obterRelatorioTipoValor($ano, $tipo_valor);
}
echo json_encode($dados);

