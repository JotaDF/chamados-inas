<?php
include('actions/ManterProcesso.php');

$p = new ManterProcesso();
$dados = $p->relatoriosPorAno();
$anos = $p->getAnos();

$response = [];

if (isset($_POST['ano2']) && $_POST['ano2'] == 'todos') {
    if ($dados) {
        $response['dados'] = $dados;
    } else {
        $response['error'] = 'Sem dados';
    }
} else {
    $response['error'] = 'Erro: O arquivo PHP não está retornando dados corretamente.';
}

// Defina o cabeçalho de resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
