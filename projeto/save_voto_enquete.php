<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once('./actions/ManterEnquete.php');

$db_enquete = new ManterEnquete();

$id_enquete = $_POST['id_enquete'];
$id_usuario = $_POST['id_usuario'];
$id_opcao = $_POST['voto'];

$db_enquete->salvarVoto($id_enquete, $id_usuario, $id_opcao);
header('Location: index.php');

