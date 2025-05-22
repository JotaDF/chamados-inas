<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once('./actions/ManterNotaGlosa.php');
require_once('./dto/NotaGlosa.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_auditoria = new ManterAuditoria();
$db_nota_glosa = new ManterNotaGlosa();
$ng = new NotaGlosa(); 

//--------------------------------------------//
$id_usuario             = $_REQUEST['id_usuario'];
$id_prestador           = $_POST['id_prestador'];
//-------------------------------------------------//
$ng->id                 = isset($_POST['id_nota']) ? $_POST['id_nota'] : 0;
$ng->numero             = $_POST['numero'];
$ng->lote               = $_POST['lote'];
$ng->valor              = $_POST['valor'];
$ng->id_recurso_glosa   = $_POST['id_recurso_glosa'];
$ng->exercicio          = $_POST['exercicio'];
$ng->data_emissao       = isset($_POST['data_emissao']) ? strtotime($_POST['data_emissao']) : '';
$ng->data_validacao     = isset($_POST['data_validacao']) ? strtotime($_POST['data_validacao']) : '';

$db_nota_glosa->salvar($ng);

header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);

