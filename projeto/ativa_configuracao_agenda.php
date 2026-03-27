<?php 
include('actions/ManterConfigAgendaPericia.php');
$manterConfigAgendaPericia = new ManterConfigAgendaPericia();
$resultado = $manterConfigAgendaPericia->ativaConfiguracao($_GET['id']);

header('Location: horarios_atendimento.php');