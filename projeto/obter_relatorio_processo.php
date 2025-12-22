<?php
require_once('actions/ManterProcesso.php');
header('Content-Type: application/json; charset=utf-8');
// Obtém os parâmetros da requisição
$ano = $_GET['ano'];
$tipo= $_GET['tipo'];
$arquivado= $_GET['arquivado'];
$ordem= $_GET['ordem'];
// Cria uma instância do ManterProcesso
$manterProcesso = new ManterProcesso();
// Inicializa a variável de dados
if($tipo == 'grafico_motivo')
    if(isset($ordem))
        $dados = $manterProcesso->getRelatorioTotalMotivosPorAno($ano, $arquivado, $ordem);
    else 
        $dados = $manterProcesso->getRelatorioTotalMotivosPorAno($ano, $arquivado, 'm.motivo');
else if($tipo == 'grafico_assunto'){
    if(isset($ordem))
        $dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado, $ordem);
    else
    $dados = $manterProcesso->getRelatorioTotalAssuntosPorAno($ano, $arquivado, 'a.assunto, sa.sub_assunto');
} else if($tipo == 'grafico_ano'){
    $dados = [];
    // Retorna todos os dados se 'ano' for 'todos'
    $resposta = $manterProcesso->relatoriosPorAno();
    if ($resposta) {
        $dados['dados'] = $resposta; // Dados encontrados
    } else {
        $dados['error'] = 'Sem dados para o ano selecionado';
    }
} else if($tipo == 'grafico_ano_mes'){
    $dados = [];
    $resposta = $manterProcesso->relatorioTotaisPorMes($ano);
    if ($resposta) {
        $dados['dados_ano'] = array_values($resposta);
    } else {
        $dados['dados_ano'] = ['error' => 'Nenhum dado encontrado para o ano selecionado.'];
    }

} 


echo json_encode($dados);

