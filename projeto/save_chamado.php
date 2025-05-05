<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once('./actions/ManterChamado.php');
require_once('./dto/Chamado.php');
require_once('./actions/ManterNotificacao.php');
require_once('./actions/ManterUsuario.php');
require_once('./dto/Notificacao.php');

$db_chamado = new ManterChamado();
$c = new Chamado();

$id_usuario = isset($_POST['usuario']) ? $_POST['usuario'] : 0;
$descricao = isset($_POST['descricao']) ? str_replace('"','',$_POST['descricao']) : '';
$red = isset($_POST['red']) ? $_POST['red'] : '';

$c->usuario = $id_usuario;
$c->descricao = addslashes(preg_replace('/\s/',' ',$descricao));

$db_chamado->salvar($c);

// Registrando notificação
$db_notificacao = new ManterNotificacao();
$db_usuario = new ManterUsuario();
$n = new Notificacao();
$n->texto   = "Um novo chamado foi aberto!";
$n->link = 'chamados.php?s=0';
$n->tipo = 'chamado';

$listaAtendentes = $db_usuario->getAtendentesChamado();
//print_r($listaAtendentes);
foreach ($listaAtendentes as $obj) {
    $n->usuario = $obj->id_usuario;
    $db_notificacao->salvar($n);
}

if($red != ''){
    header('Location: ' . $red);
} else {
    header('Location: chamados.php');
}
