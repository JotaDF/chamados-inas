<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_pagamento = new ManterNotaPagamento();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id_nota'];
$id_prestador = $_REQUEST['id_prestador'];
$data_pagamento = isset($_POST['data_pagamento']) ? strtotime($_POST['data_pagamento']) : '';
if ($id > 0) {
    $db_nota_pagamento->pagar($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Pagar Nota!";
    $a->objeto = "NotaPagameto";
    $a->informacao = "id_prestador= " . $id_prestador . " id_nota_pagamento= " . $id . " data_pagamento= ".$data_pagamento;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);
}