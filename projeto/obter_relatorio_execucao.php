<?php
require_once('actions/ManterPrestador.php');
header('Content-Type: application/json; charset=utf-8');
$manterPrestador = new ManterPrestador();
$competencia = $_GET['competencia'];


if ($competencia == "todas") {
    $anos_competencia = $_GET['ano_competencia'];
    $prestadores = $manterPrestador->getMaioresValoresPorCompetencia($anos_competencia);
    
    $lista_final = [];
    $soma_anual = 0;

    foreach ($prestadores as $p) {
        // Acumulamos os dados em um array
        $lista_final[] = [
            'valor' => $p->valor,
            'competencia' => $p->competencia,
            'razao_social' => $p->razao_social // Importante para o gráfico
        ];
        // Se o seu objeto já traz o total do mês, podemos usar para o total anual
        $soma_anual += (float)$p->valor; 
    }

    $dados = [
        'dados' => $lista_final,
        'total' => $soma_anual
    ];
    
    echo json_encode($dados);
}


if ($competencia != "todas") {
    $quantidade_exibicao = $_GET['quantidade_exibicao'];
    $dados = [
        'dados' => $manterPrestador->getPrestadoresMaioresValoresPorCompetencia($competencia, $quantidade_exibicao),
        'total' => $manterPrestador->getMaioresValoresPorCompetencia($competencia)
    ];
    echo json_encode($dados);

}



