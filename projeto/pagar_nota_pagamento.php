<?php

require_once('./actions/ManterNotaPagamento.php');

$db_nota_pagamento = new ManterNotaPagamento();

$id = $_REQUEST['id_nota'];
$id_prestador = $_REQUEST['id_prestador'];
$data_pagamento = isset($_POST['data_pagamento']) ? strtotime($_POST['data_pagamento']) : '';
if ($id > 0) {
    $db_nota_pagamento->pagar($id);
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
}
