<?php

date_default_timezone_set('America/Sao_Paulo');    

require_once('./actions/ManterTarefa.php');
require_once('./dto/Tarefa.php');
require_once('./actions/ManterNotificacao.php');
require_once('./actions/ManterUsuario.php');
require_once('./dto/Notificacao.php');

$db_tarefa  = new ManterTarefa();
$tarefa     = new Tarefa();

$id             = isset($_POST['id']) ? $_POST['id'] : 0;
$nome           = $_POST['nome'];
$descricao      = isset($_POST['descricao']) ? $_POST['descricao'] : '';
$categoria      = $_POST['categoria'];
$tipo           = $_POST['tipo'];
$inicio         = $_POST['inicio'];
$termino        = $_POST['termino'];
$criador        = $_POST['criador'];
$responsavel    = isset($_POST['responsavel']) ? $_POST['responsavel'] : 0;
$equipe         = isset($_POST['equipe']) ? $_POST['equipe'] : 0;
$duplicar       = isset($_POST['duplicar']) ? $_POST['duplicar'] : 0;

if($responsavel==''){
    $responsavel = 0;
}

$tarefa->id                  = $id;
$tarefa->nome                = $nome;
$tarefa->descricao           = html_entity_decode($descricao);
$tarefa->categoria           = $categoria;
$tarefa->tipo                = $tipo;
$tarefa->inicio              = strtotime($inicio);
$tarefa->fim                 = strtotime($termino);
$tarefa->criador             = $criador;  
$tarefa->responsavel         = $responsavel; 
$tarefa->equipe              = $equipe; 

//print_r($tarefa);
//
//echo 'DUPLICAR: ' . $duplicar; 
//$date = new DateTime();
//$date->setTimestamp($tarefa->inicio_insc);
//echo 'inicio_insc:'. $date->format('U = Y-m-d H:i:s') . "\n";

// Registrando notificação
$db_notificacao = new ManterNotificacao();
$db_usuario = new ManterUsuario();
$n = new Notificacao();
$n->texto   = "Uma nova tarefa foi criada para sua equipe!";
if($id > 0){
    $n->texto   = "Uma tarefa da sua equipe, foi alterada!";
}
$n->link = 'tarefas.php?filtro=equipe';
$n->tipo = 'tarefa';

$listaParticipantes = $db_usuario->getUsuariosPorEquipe($equipe);
foreach ($listaParticipantes as $obj) {
    $n->usuario = $obj->id;
    $db_notificacao->salvar($n);
}

if ($duplicar == 1) {
    $db_tarefa->duplicar($tarefa);
    header('Location: tarefas.php');
} else {
    $db_tarefa->salvar($tarefa);
    header('Location: tarefas.php');
}
