<?php
include('actions/ManterSlaRegulacao.php');
$r = new ManterSlaRegulacao();

// Inicializa as variáveis de resposta
$response = [];
$dados = $r->getTotaisAtraso();

// Verifica se os dados retornados não são todos zero
if ($dados['atraso_0'] > 0 || $dados['atraso_1'] > 0) {
    // Retorna os dados no formato JSON
    $response['dados'] = array(
        array(
            'fila' => 'Fila 1', // Substitua por sua lógica para cada fila
            'atraso_1' => $dados['atraso_1'],
            'atraso_0' => $dados['atraso_0']
        )
    );
} else {
    $response['error'] = 'Sem dados para o ano selecionado';
}

// Defina o cabeçalho de resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
