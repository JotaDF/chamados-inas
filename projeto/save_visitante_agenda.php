<?php

include_once('actions/ManterAgenda.php');
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');

$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

$manterAgenda = new ManterAgenda();

$id_visitante  = $_REQUEST['id_visitante'];
$id_usuario = $_REQUEST['id_usuario'];
$editor =  isset($_REQUEST['editor']) ? $_REQUEST['editor'] : 0;

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;


if ($op == 1) {
    $manterAgenda->add($id_visitante,$editor,$id_usuario);

    // Registrando notificação
    $n->texto   = "Foi liberado acesso para você a uma agenda!";
    $n->usuario = $id_visitante;
    $n->link = 'agenda.php?id=' . $id_usuario;
    $n->tipo = 'agenda';
    $db_notificacao->salvar($n);

    header('Location: gerenciar_acesso_agenda.php?id='.$id_usuario);
} else {
    $manterAgenda->del($id_visitante,$id_usuario);

    // Registrando notificação
    $n->texto   = "Foi removido o seu acesso uma agenda!";
    $n->usuario = $id_visitante;
    $n->link = 'index.php';
    $n->tipo = 'agenda';
    $db_notificacao->salvar($n);

    header('Location: gerenciar_acesso_agenda.php?id='.$id_usuario);
}
