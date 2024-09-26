<?php

require_once('./actions/ManterGlosa.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_glosa = new ManterGlosa();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_glosa->excluir($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Excluir Glosa!";
    $a->objeto = "Glosa";
    $a->informacao = "id_prestador= " . $id_prestador . " id_glosa= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
