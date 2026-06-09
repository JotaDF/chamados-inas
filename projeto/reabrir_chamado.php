<?php

//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once('./actions/ManterChamado.php');
require_once('./actions/ManterInteracao.php');
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
require_once('./dto/Chamado.php');
require_once('./dto/Interacao.php');

$db_chamado = new ManterChamado();
$c = new Chamado();
$id = isset($_REQUEST['id_chamado_reabertura']) ? $_REQUEST['id_chamado_reabertura'] : 0;
$id_usuario = isset($_REQUEST['usuario_logado_chamado']) ? $_REQUEST['usuario_logado_chamado'] : 0;

$motivo_reabertura = trim(strip_tags($_REQUEST['motivo_reabertura']))
    ?: 'Este chamado foi reaberto pela equipe da UTIC';


$mensagem = "Chamado reaberto!<br/><br/>" . $motivo_reabertura;
if ($db_chamado->reabrir($id)) {
    // Registrando interação
    $db_interacao = new ManterInteracao();
    $i = new Interacao();
    $i->texto = $mensagem;
    $i->chamado = $id;
    $i->usuario = $id_usuario;

    $db_interacao->salvar($i);
}

// Registrando notificação
$c = $db_chamado->getChamadoPorId($id);
$db_notificacao = new ManterNotificacao();
$n = new Notificacao();
$n->usuario = $c->usuario;
$n->link = 'gerenciar_interacoes.php?id=' . $id;
$n->tipo = 'interacao';
if ($id_usuario == $c->usuario) {
    $n->usuario = $c->atendente;
    $n->link = 'chamados.php?s=0';
    $n->tipo = 'chamado';
}
$n->texto = "Chamado foi reaberto!";
//print_r($n);
$db_notificacao->salvar($n);


header('Location: chamados.php');

