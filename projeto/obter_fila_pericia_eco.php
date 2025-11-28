<?php
header('Content-Type: application/json');
include('actions/ManterFilaPericiaEco.php');

$manterFilaPericiaEco = new ManterFilaPericiaEco();

$data_atual = $_GET['data'] ?? date('Y-m-d');
$periodoDatas = $manterFilaPericiaEco->getPeriodo(new DateTime());
$periodoHoras = $manterFilaPericiaEco->getHorarios();
$agenda = $manterFilaPericiaEco->criaAgenda($periodoDatas, $periodoHoras);
$datas = array_keys($agenda);
if (!$data_atual || !in_array($data_atual, $datas)) {
    $data_atual = $datas[0];
}
$horarios_agendados = $manterFilaPericiaEco->listaHorarioAgendados($data_atual);
if (!is_array($horarios_agendados)) {
    $horarios_agendados = [];
}
$disponiveis_para_data_atual = $manterFilaPericiaEco->listaHorariosDisponiveisPorData($agenda, $horarios_agendados, $data_atual);

// índice da data atual
$index = array_search($data_atual, $datas);

// anterior e próximo
$anterior = $datas[$index - 1] ?? null;
$proximo  = $datas[$index + 1] ?? null;
$response = [
    "horarios_disponiveis" => $disponiveis_para_data_atual,
    "horarios_agendados"   => $horarios_agendados,
    "data_atual"           => $data_atual,
    "anterior"             => $anterior,
    "proximo"              => $proximo
];

echo json_encode($response);
exit;
