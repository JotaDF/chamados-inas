<?php

require_once('./actions/ManterOrgaoOrigem.php');
require_once('./dto/OrgaoOrigem.php');

$db_orgao_origem = new ManterOrgaoOrigem();
$s = new OrgaoOrigem();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$nome = $_POST['nome'];

$s->id = $id;
$s->nome = $nome;

$db_orgao_origem->salvar($s);
header('Location: orgaos_origem.php');

