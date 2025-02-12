<?php
include('actions/ManterProcesso.php');
$p = new ManterProcesso();

if (isset($_POST['ano']) && $_POST['ano'] == 'todos') {
    $resposta = [];
    
    // Obtém os anos
    $anos = $p->getAnos();

    // Chama a função relatoriosTotaisPorAno com os anos obtidos
    $todos = $p->relatoriosTotaisPorAno($anos);
    
    // Se os dados foram encontrados
    if ($todos) {
        $resposta['dados'] = $todos;
    } else {
        // Caso contrário, retorna um erro
        $resposta['error'] = 'Nenhum dado encontrado para todos os anos.';
    }

    // Envia a resposta JSON
    header('Content-Type: application/json');
    echo json_encode($resposta);
    exit;
}
