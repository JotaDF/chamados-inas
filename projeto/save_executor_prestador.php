<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include_once('actions/ManterPrestador.php');
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');

$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

$manterPrestador = new ManterPrestador();

$id_prestador  = $_REQUEST['id_prestador'];
$id_usuario = $_REQUEST['id_usuario'];
$editor = isset($_REQUEST['editor']) ? $_REQUEST['editor'] : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;
$adm = isset($_REQUEST['adm']) ? $_REQUEST['adm'] : 0;


if ($op == 1) {
    $manterPrestador->add($id_prestador,$id_usuario,$editor);

    // Registrando notificação
    $n->texto   = "Você foi associado a uma prestador!";
    $n->usuario = $id_usuario;
    $n->link = 'gerenciar_prestador.php?id=' . $id_prestador;
    $n->tipo = 'prestador';
    //$db_notificacao->salvar($n);

    header('Location: gerenciar_executor_prestador.php?adm='.$adm.'&id='.$id_prestador);
} else {
    $manterPrestador->del($id_prestador,$id_usuario);

    // Registrando notificação
    $n->texto   = "Você foi removido de uma prestador!";
    $n->usuario = $id_usuario;
    $n->link = 'gerenciar_prestador.php?id=' . $id_prestador;
    $n->tipo = 'prestador';
    //$db_notificacao->salvar($n);

    header('Location: gerenciar_executor_prestador.php?adm='.$adm.'&id='.$id_prestador);
}
