<?php

require_once('./actions/ManterCartaRecurso.php');
require_once('./dto/CartaRecurso.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_auditoria = new ManterAuditoria();
$db_carta_recurso = new ManterCartaRecurso();
$cr = new CartaRecurso();


$id_usuario                    = $_REQUEST['id_usuario'];
$id_prestador                  = $_POST['id_prestador'];

$cr->id_nota_glosa             = $_POST['id_nota_glosa'];
$cr->carta_informativo         = $_POST['carta_informativo'];
$cr->exercicio                 = $_POST['exercicio'];
$cr->competencia               = $_POST['competencia'];
$cr->valor_deferido            = $_POST['valor_deferido'];
$cr->data_emissao              = $_POST['data_emissao'];
$cr->data_validacao            = $_POST['data_validacao'];
$db_carta_recurso->salvar($cr);




header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);

