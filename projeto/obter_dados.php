<?php
include_once('actions/ManterProcesso.php');
$p = new ManterProcesso();
$resposta = [];
$anos = $p->getAnos();
if (isset($_POST['ano'])) {
    $ano = $_POST['ano'];
    $dados = $p->relatorioTotaisPorMes($ano);
    if ($dados) {
        $resposta['dados_ano'] = array_values($dados);
    } else {
        $resposta['dados_ano'] = ['error' => 'Nenhum dado encontrado para o ano selecionado.'];
    }
}
// Retorna a resposta em formato JSON
header('Content-Type: application/json');
echo json_encode($resposta); // Retorna a variável $resposta
exit;
?>