<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./actions/ManterNotaGlosa.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_pagamento = new ManterNotaPagamento();
$db_nota_glosa = new ManterNotaGlosa();
$db_auditoria = new ManterAuditoria();

$dados = $_REQUEST['atesto'];
$id_prestador = $_REQUEST['id_prestador'];

$dados = $_REQUEST['atesto'];
foreach($dados as $dado){
    $reg = explode("#", $dado);
    // verifica se é nota pagamento
    if ($reg[0] == "np") {
        $db_nota_pagamento->atestar($reg[1]);
        //Auditando processo
        $a = new Auditoria();
        $a->acao = "Atestar Nota pagamento em lote!";
        $a->objeto = "NotaPagamento";
        $a->informacao = "id_nota_glosa= " . $reg[1];
        $a->autor = $reg[2];  //id usuario logado
        $db_auditoria->salvar($a);
    // verifica se é nota glosa
    } else if ($reg[0] == "ng") {
        $db_nota_glosa->atestar($reg[1]);
        //Auditando processo
        $a = new Auditoria();
        $a->acao = "Atestar Nota de glosa em lote!";
        $a->objeto = "NotaGlosa";
        $a->informacao = "id_nota_glosa= " . $reg[1];
        $a->autor = $reg[2];  //id usuario logado
        $db_auditoria->salvar($a);
    }
}
header('Location: painel_atestos_pendentes.php');

