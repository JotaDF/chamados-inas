<?php

include_once('actions/ManterContrato.php');
include_once('dto/Contrato.php');

$manterContrato = new ManterContrato();
$contrato = new Contrato();

$contrato->id  = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$contrato->prestador  = $_REQUEST['id_prestador'];
$contrato->numero = $_REQUEST['numero'];
$contrato->valor = isset($_REQUEST['valor']) ? $_REQUEST['valor'] : '';
$contrato->ano = $_REQUEST['ano'];
$contrato->vigente = isset($_REQUEST['vigente']) ? $_REQUEST['vigente'] : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;

$caminho = __DIR__.'/contratos/'.$contrato->numero.'_'.$contrato->ano.'/';

if ($op == 1) {
    $manterContrato->salvar($contrato);
    $manterContrato->addPasta($caminho);
    header('Location: gerenciar_contratos_prestador.php?id='.$contrato->prestador);
 } if ($op == 2) {
    $manterContrato->salvar($contrato);
    header('Location: gerenciar_contratos_prestador.php?id='.$contrato->prestador);
 } else {
    $manterContrato->excluir($contrato->id);
    $manterContrato->delPasta($caminho);
    header('Location: gerenciar_contratos_prestador.php?id='.$contrato->prestador);
}
