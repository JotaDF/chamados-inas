<?php
header('Content-Type: application/json');
include('actions/ManterFilaPericiaEco.php');
include('actions/ManterConfigAgendaPericia.php');

$manterFilaPericiaEco = new ManterFilaPericiaEco();
$manterConfigAgendaPericia = new ManterConfigAgendaPericia();

$horarios = $manterConfigAgendaPericia->getConfiguracaoAtiva();
$agenda = $manterFilaPericiaEco->gerarAgenda($horarios);
 
$data_atual = $manterFilaPericiaEco->getDiaAtual($_GET['data'] ?? null, $agenda); 
$lista_data_feriados = $manterFilaPericiaEco->geraListaFeriados(); 

$resultado = $manterFilaPericiaEco->processarData($data_atual, $agenda, $lista_data_feriados); 
$response = $manterFilaPericiaEco->criaResposta($data_atual, $resultado);

echo json_encode($response);
exit;
    