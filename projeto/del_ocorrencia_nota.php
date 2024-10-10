<?php

include_once('actions/ManterOcorrenciaNota.php');

$manterOcorrenciaNota = new ManterOcorrenciaNota();

$id_prestador  = $_REQUEST['id_prestador'];
$id_usuario = $_REQUEST['id_usuario'];
$descricao = $_REQUEST['descricao'];
$id_nota = $_REQUEST['id_nota'];
$id = $_REQUEST['id'];
$tp = isset($_REQUEST['tp']) ? $_REQUEST['tp'] : 1;

$manterOcorrenciaNota->excluir($id);
header('Location: gerenciar_ocorrencias_nota.php?id_prestador='.$id_prestador.'&id='.$id_nota.'&tp='.$tp);

