<?php

require_once('./actions/ManterPagamentoPrestador.php');

$db_pagamento = new ManterPagamentoPrestador();

$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_pagamento->excluir($id);
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
}
