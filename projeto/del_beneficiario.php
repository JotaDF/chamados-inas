<?php
require_once('./actions/ManterBeneficiario.php');
require_once('./dto/Beneficiario.php');

$db_beneficiario = new ManterBeneficiario();

$b = new Beneficiario();

$id = $_REQUEST['id'];

$db_beneficiario->excluir($id);

