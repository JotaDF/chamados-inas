<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once('./actions/ManterPagamento.php');

$db_pagamento = new ManterPagamento();

$informativo = $_REQUEST['informativo'];
$id_prestador = $_REQUEST['id_prestador'];

echo $db_pagamento->verificaInformativo($id_prestador,$informativo);
