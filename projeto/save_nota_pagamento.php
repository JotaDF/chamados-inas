<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./dto/OpcaoNotaPagamento.php');

$db_nota_pagamento = new ManterNotaPagamento();
$np = new NotaPagamento();

$id_prestador       = $_POST['id_prestador'];

$np->pagamento       = $_POST['id_pagamento'];
$np->numero             = $_POST['numero'];
$np->valor              = $_POST['valor'];
$np->exercicio          = $_POST['exercicio'];
$np->data_emissao       = $_POST['data_emissao'];
$np->data_validacao     = $_POST['data_validacao'];

$db_nota_pagamento->save($np);

header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);

