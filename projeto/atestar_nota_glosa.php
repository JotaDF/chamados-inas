<?php

require_once('./actions/ManterCartaRecurso.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_carta_recurso = new ManterCartaRecurso();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_carta_recurso->atestar($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Atestar Nota!";
    $a->objeto = "CartaRecurso";
    $a->informacao = "id_prestador= " . $id_prestador . " id_carta_recurso= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
