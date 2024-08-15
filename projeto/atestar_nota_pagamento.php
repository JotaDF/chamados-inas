<?php

require_once('./actions/ManterNotaPagamento.php');

$db_nota_pagamento = new ManterNotaPagamento();

$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_nota_pagamento->atestar($id);
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
}
