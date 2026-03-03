<?php 
include ('actions/ManterAtendimentoPericia.php');
$manterAtendimentoPericia = new ManterAtendimentoPericia();

$resultado = $manterAtendimentoPericia->desmarcaAgendamento($_POST['id_atendimento']);
