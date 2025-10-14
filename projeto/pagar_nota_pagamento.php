<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_pagamento = new ManterNotaPagamento();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id_nota'];
$id_prestador = $_REQUEST['id_prestador'];
$doc_sei = $_REQUEST['doc_sei'];
$data = isset($_REQUEST['data_pagamento']) ? new DateTime($_REQUEST['data_pagamento']) : '';
$data_pagamento = mktime (0, 0, 0, $data->format("m"), $data->format("d"),  $data->format("Y"));

$adm = isset($_REQUEST['adm']) ? $_REQUEST['adm'] : 0;

$painel = isset($_REQUEST['painel']) ? $_REQUEST['painel'] : 0;
$url = 'gerenciar_pagamentos_prestador.php?id='.$id_prestador;

if($adm == 1){
    $url = 'gerenciar_pagamentos_prestador_adm.php?id='.$id_prestador;
}
if($painel == 1){
    $url = 'painel_meus_pagamentos_pendentes.php';
} elseif ($painel == 2) {
    $url = 'painel_pagamentos_pendentes.php';
}

if ($id > 0) {
    $db_nota_pagamento->pagar($id, $data_pagamento, $doc_sei);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Pagar Nota!";
    $a->objeto = "NotaPagameto";
    $a->informacao = "id_prestador= " . $id_prestador . " id_nota_pagamento= " . $id . " data_pagamento= ".$data_pagamento;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: '.$url);
} else {
    echo 'Falta de parâmetro!';
    header('Location: '.$url);
}
