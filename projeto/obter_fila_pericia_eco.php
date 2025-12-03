<?php
header('Content-Type: application/json');
include('actions/ManterFilaPericiaEco.php');
include('actions/ManterFeriadoAno.php');
$manterFeriadoAno = new ManterFeriadoAno();
$manterFilaPericiaEco = new ManterFilaPericiaEco();

$feriados = $manterFeriadoAno->lista();
$data_feriados = [];
foreach ($feriados as $f) {
    $data_feriados[] = $f->data;
}
// var_dump($datas_feriados);
$data_atual = $_GET['data'] ?? date('Y-m-d');
$periodoDatas = $manterFilaPericiaEco->getPeriodo(new DateTime());
$periodoHoras = $manterFilaPericiaEco->getHorarios();
$agenda = $manterFilaPericiaEco->criaAgenda($periodoDatas, $periodoHoras);

$datas = array_keys($agenda);
if (!$data_atual || !in_array($data_atual, $datas)) {
    $data_atual = $datas[1];
}
$horarios_agendados = $manterFilaPericiaEco->listaHorarioAgendadosPorData($data_atual);
if (!is_array($horarios_agendados)) {
    $horarios_agendados = [];
}
$datas_limpas = [];
foreach ($datas as $d) {
    if (!in_array($d, $data_feriados)) {
        $datas_limpas[] = $d;
    }
}


// var_dump($datas_limpas);
$disponiveis_para_data_atual = $manterFilaPericiaEco->listaHorariosDisponiveisPorData($agenda, $horarios_agendados, $data_atual);

// índice da data atual
$index = array_search($data_atual, $datas_limpas);

// anterior e próximo
$anterior = $datas_limpas[$index - 1] ?? null;
$proximo = $datas_limpas[$index + 1] ?? null;

$dia_semana = date('l', strtotime($data_atual));
$response = [
    "horarios_disponiveis" => $disponiveis_para_data_atual,
    "horarios_agendados" => $horarios_agendados,
    "agenda" => $datas_limpas,
    "dia_semana" => $dia_semana,
    "data_atual" => $data_atual,
    "anterior" => $anterior,
    "proximo" => $proximo
];

echo json_encode($response);
exit;
