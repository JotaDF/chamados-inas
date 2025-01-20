<?php
require_once('./actions/ManterNotaGlosa.php');
require_once('./dto/NotaGlosa.php');

require_once('./actions/ManterCartaRecurso.php');
require_once('./dto/CartaRecurso.php');

$db_nota_glosa = new ManterNotaGlosa();
$db_carta_recurso = new ManterCartaRecurso();

$notas = $db_nota_glosa->listar();
foreach ($notas as $ng) {
    if($n->id > 0){
    $cre = new CartaRecurso();
    $cre->id_nota_glosa        = $ng->id;
    $cre->data_emissao         = $ng->data_emissao;
    $cre->data_validacao       = $ng->data_validacao;
    $cre->data_atesto          = $ng->data_atesto;
    $cre->data_pagamento       = $ng->data_pagamento;
    $cre->status               = $ng->status;
    $db_carta_recurso->migrar($cre);  
    echo "Carta Recurso id_nota_glosa: " . $cre->id_nota_glosa ."<br/>";
     }
}