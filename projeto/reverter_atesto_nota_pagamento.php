<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_pagamento = new ManterNotaPagamento();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
$painel = isset($_REQUEST['painel']) ? $_REQUEST['painel'] : 0;
$adm = isset($_REQUEST['adm']) ? $_REQUEST['adm'] : 0;

$url = 'gerenciar_glosas_prestador.php?id='.$id_prestador;

if($adm == 1){
    $url = 'gerenciar_pagamentos_prestador_adm.php?id='.$id_prestador;
}

if ($id > 0) {
    $db_nota_pagamento->reverterExecucao($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Reverter Atesto de Nota!";
    $a->objeto = "NotaPagameto";
    $a->informacao = "id_prestador= " . $id_prestador . " id_nota_pagamento= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: '.$url);
} else {
    echo 'Falta de parâmetro!';
    header('Location: '.$url);
}
