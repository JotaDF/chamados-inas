<?php
require_once('dto/ConfigAgendaPericia.php');
require_once('actions/ManterConfigAgendaPericia.php');

$a = new ConfigAgendaPericia();

$id = $_POST['id_agenda_pericia'] ?? 0;

$a->id = $id;
$a->nome = $_POST['nome'];
$a->matutino_inicio = $_POST['matutino_inicio'];
$a->matutino_fim = $_POST['matutino_fim'];
$a->matutino_intervalo = $_POST['matutino_intervalo'];
$a->vespertino_inicio = $_POST['vespertino_inicio'];
$a->vespertino_fim = $_POST['vespertino_fim'];
$a->vespertino_intervalo = $_POST['vespertino_intervalo'];
$a->usuario = $_POST['id_usuario'];
$db_agenda_pericia = new ManterConfigAgendaPericia();

$resultado = $id > 0
    ? $db_agenda_pericia->atualizaConfiguracao($a)
    : $db_agenda_pericia->registraConfiguracao($a);

if ($resultado) {
    header('Location: horarios_atendimento.php');
}