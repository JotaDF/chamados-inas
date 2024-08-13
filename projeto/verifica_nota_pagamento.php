<?php

require_once('./actions/ManterNotaPagamento.php');

$db_nota_pagamento = new ManterNotaPagamento();

$numero = $_REQUEST['numero'];
$id_prestador = $_REQUEST['id_prestador'];

echo $db_pagamento->verificaNotaPorPrestador($id_prestador,$numero);
