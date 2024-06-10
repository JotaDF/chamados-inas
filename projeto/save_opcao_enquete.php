<?php

require_once('./actions/ManterEnquete.php');
require_once('./dto/OpcaoEnquete.php');

$db_enquete = new ManterEnquete();
$op = new OpcaoEnquete();

$id_enquete = isset($_POST['id_enquete']) ? $_POST['id_enquete'] : 0;
$opcao = isset($_POST['opcao']) ? $_POST['opcao'] : '';

$op->id_enquete = $id_enquete;
$op->opcao = $opcao;

$db_enquete->addOpcao($op);
header('Location: gerenciar_opcoes_enquete.php?id='.$id_enquete);

