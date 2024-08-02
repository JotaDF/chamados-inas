<?php

require_once('./actions/ManterPagamento.php');
require_once('./dto/Pagamento.php');

$db_pagamento = new ManterPagamento();
$p = new Pagamento();

$id_prestador = $_POST['id_prestador'];
$id_fiscal_prestador = $_POST['id_fiscal_prestador'];
$competencia = $_POST['competencia'];
$informativo = $_POST['informativo'];

$p->fiscal_prestador = $id_fiscal_prestador;
$p->competencia = $competencia;
$p->informativo = $informativo;

$db_pagamento->salvar($p);
header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);

