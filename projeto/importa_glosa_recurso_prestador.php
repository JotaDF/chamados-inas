<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('./actions/ManterNotaGlosa.php');
require_once('./dto/NotaGlosa.php');

require_once('./actions/ManterCartaRecurso.php');
require_once('./dto/CartaRecurso.php');

$db_nota_glosa = new ManterNotaGlosa();
$db_carta_recurso = new ManterCartaRecurso();

$notas = $db_nota_glosa->listar();
foreach ($notas as $ng) {
    if($ng->id > 0){
    $cre = new CartaRecurso();
    $cre->id_nota_glosa        = $ng->id;
    $cre->data_emissao         = $ng->data_emissao;
    $cre->data_executado       = $ng->data_executado;
    $cre->data_validacao       = $ng->data_validacao;
    $cre->data_atesto          = $ng->data_atesto;
    $cre->data_pagamento       = $ng->data_pagamento;
    $cre->doc_sei	       = $ng->doc_sei;
    $cre->status               = $ng->status;
    $db_carta_recurso->migrar($cre);  
    echo "Carta Recurso id_nota_glosa: " . $cre->id_nota_glosa ."<br/>";
     }
}
