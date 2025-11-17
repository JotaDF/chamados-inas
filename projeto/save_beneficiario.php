<?php
require_once('./actions/ManterBeneficiario.php');
require_once('./dto/Beneficiario.php');

$db_beneficiario = new ManterBeneficiario();
$b = new Beneficiario();

$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : 0;

$b->cpf = $cpf;
$b->telefone = $_POST['telefone'];
$b->email = $_POST['email'];

$db_beneficiario->salvar($b);
header('Location: beneficiario.php');


