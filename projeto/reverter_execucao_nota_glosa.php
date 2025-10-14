<?php

require_once('./actions/ManterCartaRecurso.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_carta_recurso = new ManterCartaRecurso();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];

$painel = isset($_REQUEST['painel']) ? $_REQUEST['painel'] : 0;
$url = 'gerenciar_glosas_prestador.php?id='.$id_prestador;


if ($id > 0) {
    $db_carta_recurso->reverterExecucao($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Reverter Execução de Nota!";
    $a->objeto = "CartaRecurso";
    $a->informacao = "id_prestador= " . $id_prestador . " id_carta_recurso= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: '.$url);
} else {
    echo 'Falta de parâmetro!';
    header('Location: '.$url);
}
