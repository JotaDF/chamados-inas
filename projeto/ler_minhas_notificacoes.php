<?php

require_once('./actions/ManterNotificacao.php');

$db_notificacao = new ManterNotificacao();


$notificacoes[] = $_REQUEST['notificacao'];

foreach($notificacoes as $id){
    $db_notificacao->ler($id);
}

header('Location: gerenciar_notificacoes.php');

