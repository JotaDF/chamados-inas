<?php

require_once('./actions/ManterCartaRecurso.php');
require_once('./dto/CartaRecurso.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_auditoria = new ManterAuditoria();
$db_carta_recurso = new ManterCartaRecurso();
$cr = new CartaRecurso();


$id            = $_REQUEST['id'];
$id_prestador  = $_POST['id_prestador'];

$db_carta_recurso->excluir($id);


header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);

