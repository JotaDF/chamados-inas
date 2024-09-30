<?php

require_once('./actions/ManterNotaPagamento.php');
require_once('./actions/ManterNotaGlosa.php');

$db_nota_pagamento = new ManterNotaPagamento();
$db_nota_glosa = new ManterNotaGlosa();

$dados = $_REQUEST['atesto'];
$id_prestador = $_REQUEST['id_prestador'];

$dados = $_REQUEST['atesto'];
foreach($dados as $dado){
    $reg = explode("#", $dado);
    if ($reg[0] == "np") {
        $db_nota_pagamento->atestar($reg[1]);
    } else if ($reg[0] == "ng") {
        $db_nota_glosa->atestar($reg[1]);
    }
}
header('Location: painel_atestos_pendentes.php');

