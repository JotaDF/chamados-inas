<?php

require_once('./actions/ManterEnquete.php');
require_once('./dto/Enquete.php');

$db_enquete = new ManterEnquete();
$p = new Enquete();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';

$p->id = $id;
$p->descricao = $descricao;

$db_enquete->salvar($p);
header('Location: enquetes.php');

