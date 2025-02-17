<?php
include('actions/ManterProcesso.php');

// Cria uma instância do objeto ManterProcesso
$p = new ManterProcesso();

// Inicializa as variáveis de resposta
$response = [];

// Exemplo de como obter o ano diretamente (você pode modificar a lógica conforme necessário)
$ano = 'todos'; // Se você sempre quiser retornar todos os dados, defina 'todos'. Caso contrário, defina um ano específico.

if ($ano === 'todos') {
    // Retorna todos os dados se 'ano' for 'todos'
    $dados = $p->relatoriosPorAno();
    if ($dados) {
        $response['dados'] = $dados; // Dados encontrados
    } else {
        $response['error'] = 'Sem dados para o ano selecionado';
    }
} else {
    // Caso contrário, retorna os dados específicos para o ano selecionado
    $dados = $p->relatoriosPorAno($ano); // Certifique-se de que esta função recebe o ano como parâmetro
    if ($dados) {
        $response['dados'] = $dados; // Dados encontrados para o ano específico
    } else {
        $response['error'] = 'Sem dados para o ano selecionado';
    }
}

// Defina o cabeçalho de resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
