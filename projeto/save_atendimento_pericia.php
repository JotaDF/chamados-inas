<?php
require_once('./actions/ManterAtendimentoPericia.php');
require_once('./dto/AtendimentoPericia.php');

$db_atendimento_pericia = new ManterAtendimentoPericia();
$a = new AtendimentoPericia();

$id = isset($_POST['id']) ? $_POST['id'] : 0;

$a->id = $id;

$db_atendimento_pericia->salvar($a);
header('Location: atendimento_pericia.php');


