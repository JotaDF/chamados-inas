<?php


require_once('actions/ManterAcao.php');

$db_acao = new ManterAcao();



$id     = $_REQUEST['id'];
$op     = $_REQUEST['op'];
$tipo   = $_REQUEST['tipo'];
$ordem  = $_REQUEST['ordem'];
$etapa  = $_REQUEST['etapa'];
$tarefa = $_REQUEST['tarefa'];

//echo 'ID:' .$_REQUEST['id'] . ' ACAO: '.$_REQUEST['acao'] . ' ORDEM: '.$_REQUEST['ordem'] . ' ETAPA: '.$_REQUEST['etapa'] ;

//print_r($acao);
if ($op == "s") {
    $db_acao->sobeOrdem($id, $tipo, $etapa, $ordem);
} else if ($op == "d") {
    $db_acao->desceOrdem($id, $tipo, $etapa, $ordem);
}


header('Location: relatorio_etapas.php?tarefa='.$tarefa);
