<?php

require_once('./actions/ManterFila.php');
require_once('./dto/Fila.php');

$db_fila = new ManterFila();
$f = new Fila();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$id_servico = $_POST['servico'];
$preferencial = isset($_POST['preferencial']) ? $_POST['preferencial'] : 0;

$f->id = $id;
$f->cpf = $cpf;
$f->nome = $nome;
$f->servico = $id_servico;
$f->preferencial = $preferencial;

$db_fila->salvar($f);
header('Location: gerenciar_fila.php');

