<?php


require_once('./actions/ManterAcao.php');
require_once('./dto/Acao.php');

$db_acao = new ManterAcao();
$a = new Acao();

//echo 'ID:' .$_POST['id'] . ' ACAO: '.$_POST['acao'] . ' ORDEM: '.$_POST['ordem'] . ' ETAPA: '.$_POST['etapa'] ;

$id     = isset($_POST['id']) ? $_POST['id'] : 0;
$tipo   = $_POST['tipo_acao'];
$acao   = $_POST['acao'];
$ordem_acao  = $_POST['ordem_acao'];
$ordem_nota  = $_POST['ordem_nota'];
$etapa  = $_POST['etapa'];
$tarefa = $_POST['tarefa'];
$data_prevista  = isset($_POST['data_prevista']) ? strtotime($_POST['data_prevista']) : 0; 

$a->id              = $id;
$a->acao            = $acao;
$a->tipo            = $tipo;
if($tipo==1){
    $a->ordem = $ordem_acao;
} else {
    $a->ordem =  $ordem_nota;
}   
$a->etapa           = $etapa;
$a->data_prevista   = $data_prevista;

//print_r($acao);

$db_acao->salvar($a,$tarefa);

header('Location: gerenciar_etapas.php?tarefa='.$tarefa);

