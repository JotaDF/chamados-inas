<?php

require_once('./actions/ManterSolicitacao.php');
require_once('./actions/ManterInteracaoSolicitacao.php');
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
require_once('./dto/Solicitacao.php');
require_once('./dto/Interacao.php');


$db_solicitacao = new ManterSolicitacao();
$db_notificacao = new ManterNotificacao();
$c = new Solicitacao();

$id_solicitacao = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$id_usuario = isset($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 0;

$db_solicitacao->cancelar($id_solicitacao);


// Registrando interação
$db_interacao = new ManterInteracaoSolicitacao();

$db_interacao->registrarInteracao("Solicitação cancelada!", $id_solicitacao, $id_usuario);
// Registrando notificação

header('Location: solicitacoes_dijur.php?s=1');

