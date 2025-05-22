<?php 
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once('./actions/ManterCartaRecursada.php');
require_once('./dto/CartaRecursada.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_cartaRecursada = new ManterCartaRecursada();
$cr = new CartaRecursada();
$db_auditoria = new ManterAuditoria();

$id_usuario   = $_REQUEST['id_usuario'];

$id_prestador = $_POST['id_prestador'];
$id_fiscal_prestador = $_POST['id_fiscal_prestador'];

$carta_recursada = $_POST['carta_recursada'];
$valor_original = $_POST['valor_original'];

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$cr->id = $id;
$cr->id_fiscal_prestador = $id_fiscal_prestador;
$cr->carta_recursada = $carta_recursada;
$cr->valor_original = $valor_original;

$db_cartaRecursada->salvar($cr);

$a = new Auditoria();
$a->acao = "Cadastrar Pagamento!";
$a->objeto = "Pagameto";
$a->informacao = "id_prestador= " . $id_prestador . " id_fiscal_prestador= " . $id_fiscal_prestador
               . " carta_recursada= ".$carta_recursada . " valor_original= ".$valor_original ;
$a->autor = $id_usuario;
$db_auditoria->salvar($a);

header('Location: gerenciar_glosas_prestador.php?id='.$id_prestador);
