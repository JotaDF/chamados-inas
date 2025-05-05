<?php
require_once('./actions/ManterNotificacao.php');
	
$db_notificacao = new ManterNotificacao();
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
echo $db_notificacao->getTotalNotificacaoNaoLidasUsuario($id);



