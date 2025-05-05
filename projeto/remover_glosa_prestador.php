<?php

require_once('./actions/ManterCartaRecursada.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_carta_recursada = new ManterCartaRecursada();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_carta_recursada->excluir($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Excluir CartaRecursada!";
    $a->objeto = "CartaRecursada";
    $a->informacao = "id_prestador= " . $id_prestador . " id_carta_recursada= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
