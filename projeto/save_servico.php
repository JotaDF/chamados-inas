<?php

require_once('./actions/ManterServico.php');
require_once('./dto/Servico.php');

$db_servico = new ManterServico();
$s = new Servico();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$nome = $_POST['nome'];

$s->id = $id;
$s->nome = $nome;

$db_servico->salvar($s);
header('Location: servicos.php');

