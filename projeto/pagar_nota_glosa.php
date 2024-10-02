<?php

require_once('./actions/ManterNotaGlosa.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_glosa = new ManterNotaGlosa();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id_nota'];
$id_prestador = $_REQUEST['id_prestador'];
$doc_sei = $_REQUEST['doc_sei'];
$data = isset($_REQUEST['data_pagamento']) ? new DateTime($_REQUEST['data_pagamento']) : '';
$data_glosa = mktime (0, 0, 0, $data->format("m"), $data->format("d"),  $data->format("Y"));

$painel = isset($_REQUEST['painel']) ? $_REQUEST['painel'] : 0;
$url = 'gerenciar_glosas_prestador.php?id='.$id_prestador;
if($painel > 0){
    $url = 'painel_meus_pagamentos_pendentes.php';
}

if ($id > 0) {
    $db_nota_glosa->pagar($id, $data_glosa, $doc_sei);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Pagar Nota!";
    $a->objeto = "NotaGlosa";
    $a->informacao = "id_prestador= " . $id_prestador . " id_nota_glosa= " . $id . " data_glosa= ".$data_glosa. " doc_sei= ".$doc_sei;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: '.$url);
} else {
    echo 'Falta de parâmetro!';
    header('Location: '.$url);
}
