<?php

require_once('./actions/ManterNotaGlosa.php');
require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_nota_glosa = new ManterNotaGlosa();
$db_auditoria = new ManterAuditoria();

$id_usuario = $_REQUEST['id_usuario'];
$id = $_REQUEST['id'];
$id_prestador = $_REQUEST['id_prestador'];
if ($id > 0) {
    $db_nota_glosa->excluir($id);
    //Auditando processo
    $a = new Auditoria();
    $a->acao = "Excluir Nota!";
    $a->objeto = "NotaGlosa";
    $a->informacao = "id_prestador= " . $id_prestador . " id_nota_glosa= " . $id;
    $a->autor = $id_usuario;
    $db_auditoria->salvar($a);

    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
}
