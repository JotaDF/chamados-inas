<?php

require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');

$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

//echo 'ID:' .$_POST['id'] ;

$id         = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$n = $db_notificacao->getNotificacaoPorId($id);


//print_r($notificacao);

$db_notificacao->ler($id);

header('Location: ' . $n->link);

