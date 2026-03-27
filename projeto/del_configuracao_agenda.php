<?php 
include('actions/ManterConfigAgendaPericia.php');
$db_configAgendaPericia_pericia = new ManterConfigAgendaPericia();

$resultado = $db_configAgendaPericia_pericia->excluirConfiguracao($_GET['id']);

if($resultado) {
    header('Location: horarios_atendimento.php');
}