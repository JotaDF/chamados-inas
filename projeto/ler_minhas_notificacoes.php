<?php

require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');

$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

//echo 'ID:' .$_POST['id'] ;

$notificacoes[] = $_REQUEST['notificacao'];

foreach($notificacoes as $id){
    $n = $db_notificacao->getNotificacaoPorId($id);
    $db_notificacao->ler($n);
}

header('Location: gerenciar_notificacoes.php');

