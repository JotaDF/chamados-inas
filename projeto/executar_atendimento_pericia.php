<?php
require_once('./actions/ManterAtendimentoPericia.php');
require_once('./dto/AtendimentoPericia.php');

$db_agendamento_pericia = new ManterAtendimentoPericia();
$a = new AtendimentoPericia();

$id_fila = isset($_POST['id_fila']) ? $_POST['id_fila'] : 0;
$id = isset($_POST['id']) ? $_POST['id'] : 0;

$a->id = $id;
$a->fila = $id_fila;
$a->id_medico_perito = (int) $_POST['medico_perito'];
$a->situacao = $_POST['situacao_atendimento'];
$a->resultado = $_POST['resultado'];
$a->atualizado = $_POST['atualizado'];


$resultado = $db_agendamento_pericia->salvar($a);
if ($resultado) {
    header('Location: agendamentos.php?data=' . $data_agendada);
}