<?php
require_once('actions/ManterPrestador.php');
require_once('actions/ManterNotaGlosa.php');
header('Content-Type: application/json; charset=utf-8');
$manterPrestador = new ManterPrestador();
$manterNotaGlosa = new ManterNotaGlosa();
$competencia = $_GET['competencia'];
$campo = $_GET['campo'];

if ($campo == 'grafico_nota_pagamento') {
    if ($competencia == 'todas') {
        $anos_competencia = $_GET['ano_competencia'];
        $dados = $manterPrestador->getNotaPagamentoTodasCompetencias($anos_competencia);
    }

    if ($competencia != "todas") {
        $quantidade_exibicao = $_GET['quantidade_exibicao'];
        $dados = $manterPrestador->getDadosPrestadoresNotaPagamento($quantidade_exibicao, $competencia);
    }
}

if ($campo == 'grafico_nota_glosa') {
    if ($competencia == 'todas') {
        $anos_competencia = $_GET['ano_competencia'];
        $dados = $manterNotaGlosa->getNotaGlosaTodasCompetencias($anos_competencia);
    }

    if ($competencia != "todas") {
        $quantidade_exibicao = $_GET['quantidade_exibicao'];
        $dados = $manterNotaGlosa->getDadosPrestadoresNotaGlosa($quantidade_exibicao, $competencia);
    }
}

echo json_encode($dados);

