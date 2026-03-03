<?php
require_once('./actions/ManterAtendimentoPericia.php');
require_once('./dto/AtendimentoPericia.php');

$db_agendamento_pericia = new ManterAtendimentoPericia();
$a = new AtendimentoPericia();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$id_fila = isset($_POST['id_fila']) ? $_POST['id_fila'] : 0;
$id_atendimento = isset($_POST['id_atendimento']) && $_POST['id_atendimento'] !== '' ? $_POST['id_atendimento'] : 0;
$data_agendada = $_POST['data_agendada'];
$hora_agendada = $_POST['hora_agendada'];

if ($id_atendimento > 0) {
    $resultado = $db_agendamento_pericia->reagendar($id_atendimento, $data_agendada, $hora_agendada);
    header('Location: agendamentos.php?data=' . $data_agendada);
    exit();
}

$a->id = $id;
$a->fila = $id_fila;
$a->hora_agendada = $hora_agendada;
$a->data_agendada = $data_agendada;
$a->usuario = $_POST['id_usuario'];
$a->situacao = "SISTEMA";

$resultado = $db_agendamento_pericia->salvar($a);
if ($resultado) {
    header('Location: agendamentos.php?data=' . $data_agendada);
}
