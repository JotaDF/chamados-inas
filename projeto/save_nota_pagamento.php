<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once('./actions/ManterNotaPagamento.php');
require_once('./dto/NotaPagamento.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_auditoria = new ManterAuditoria();

$db_nota_pagamento = new ManterNotaPagamento();
$np = new NotaPagamento();


$id_usuario         = $_REQUEST['id_usuario'];
$id_prestador       = $_POST['id_prestador'];

$np->pagamento       = $_POST['id_pagamento'];
$np->numero             = $_POST['numero'];
$np->valor              = $_POST['valor'];
$np->exercicio          = $_POST['exercicio'];
$np->data_emissao       = isset($_POST['data_emissao']) ? strtotime($_POST['data_emissao']) : '';
$np->data_validacao     = isset($_POST['data_validacao']) ? strtotime($_POST['data_validacao']) : '';

$db_nota_pagamento->salvar($np);

//Auditando processo
$a = new Auditoria();
$a->acao = "Cadastrar Nota!";
$a->objeto = "NotaPagameto";
$a->informacao = "id_prestador= " . $id_prestador . " id_pagamento= " . $np->pagamento
               . " numero= ".$np->numero . " valor= ".$np->valor . " exercicio= ".$np->exercicio
               . " data_emissao= ".$np->data_emissao . " data_validacao= ".$np->data_validacao ;
$a->autor = $id_usuario;
$db_auditoria->salvar($a);

header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);

