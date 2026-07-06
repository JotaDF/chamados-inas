<?php

require_once('./actions/ManterSolicitacao.php');
require_once('./actions/ManterInteracaoSolicitacao.php');
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
require_once('./dto/Solicitacao.php');
require_once('./dto/Interacao.php');


$db_solicitacao = new ManterSolicitacao();
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$atendente = isset($_REQUEST['atendente']) ? $_REQUEST['atendente'] : 0;

$s = new Solicitacao();
$s->id = $id;

$db_solicitacao->atender($s);


// Registrando interação
$db_interacao = new ManterInteracaoSolicitacao();

$db_interacao->registrarInteracao("Início do atendimento da solicitação!", $id, $atendente);


// Registrando notificação
// $s = $db_chamado->getChamadoPorId($id);
// $db_notificacao = new ManterNotificacao();
// $n = new Notificacao();
// $n->texto   = "Atendimento do chamado foi iniciado!";
// $n->usuario = $s->usuario;
// $n->link = 'gerenciar_interacoes.php?id=' . $id;
// $n->tipo = 'interacao';
// $db_notificacao->salvar($n);

header('Location: gerenciar_interacoes_solicitacao.php?id=' . $id);

