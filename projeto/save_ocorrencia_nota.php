<?php

include_once('actions/ManterOcorrenciaNota.php');
include_once('dto/OcorrenciaNota.php');

$db_ocorrencia = new ManterOcorrenciaNota();
$o = new OcorrenciaNota();

$manterOcorrenciaNota = new ManterOcorrenciaNota();

$id_prestador  = $_REQUEST['id_prestador'];
$id_usuario = $_REQUEST['id_usuario'];
$descricao = $_REQUEST['descricao'];
$id_nota = $_REQUEST['id_nota'];
$id = $_REQUEST['id'];
$tp = isset($_REQUEST['tp']) ? $_REQUEST['tp'] : 1;

$o->id = $id;
$o->autor = $id_usuario;
$o->descricao = $descricao;
if ($tp == 1) {
    $o->nota_pagamento = $id_nota;
    $o->nota_glosa = null;
} else {
    $o->nota_glosa = $id_nota;
    $o->nota_pagamento = null;
}
$manterOcorrenciaNota->salvar($o);
header('Location: gerenciar_ocorrencias_nota.php?id_prestador='.$id_prestador.'&id='.$id_nota.'&tp='.$tp);

