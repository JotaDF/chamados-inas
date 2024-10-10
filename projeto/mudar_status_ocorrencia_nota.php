<?php

include_once('actions/ManterOcorrenciaNota.php');
include_once('dto/OcorrenciaNota.php');

$db_ocorrencia = new ManterOcorrenciaNota();
$o = new OcorrenciaNota();

$manterOcorrenciaNota = new ManterOcorrenciaNota();

$id_prestador  = $_REQUEST['id_prestador'];
$id_nota = $_REQUEST['id_nota'];
$id = $_REQUEST['id'];
$tp = isset($_REQUEST['tp']) ? $_REQUEST['tp'] : 1;

$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;

if ($status == 1) {
    $manterOcorrenciaNota->resolver($id);
} else {
    $manterOcorrenciaNota->desresolver($id);
}

header('Location: gerenciar_ocorrencias_nota.php?id_prestador='.$id_prestador.'&id='.$id_nota.'&tp='.$tp);