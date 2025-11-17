<?php
require_once('./actions/ManterAtendimentoPericia.php');
require_once('./dto/AtendimentoPericia.php');

$db_atendimento_pericia = new ManterAtendimentoPericia();

$a = new AtendimentoPericia();

$id = $_REQUEST['id'];

$db_atendimento_pericia->excluir($id);

