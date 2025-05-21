<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);ini_set('display_errors',1);

require_once('./actions/ManterPagamento.php');
require_once('./dto/Pagamento.php');

require_once('./actions/ManterAuditoria.php');
require_once('./dto/Auditoria.php');

$db_auditoria = new ManterAuditoria();

$db_pagamento = new ManterPagamento();
$p = new Pagamento();


$id_usuario   = $_REQUEST['id_usuario'];

$id_prestador = $_POST['id_prestador'];
$id_fiscal_prestador = $_POST['id_fiscal_prestador'];
$competencia = $_POST['competencia'];
$informativo = $_POST['informativo'];
$id_pagamento = isset($_POST['id_pagamento']) ? $_POST['id_pagamento'] : 0;

$p->id = $id_pagamento;
$p->fiscal_prestador = $id_fiscal_prestador;
$p->competencia = $competencia;
$p->informativo = $informativo;

$db_pagamento->salvar($p);

//Auditando processo
$a = new Auditoria();
$a->acao = "Cadastrar Pagamento!";
$a->objeto = "Pagameto";
$a->informacao = "id_prestador= " . $id_prestador . " id_fiscal_prestador= " . $id_fiscal_prestador
               . " competencia= ".$competencia . " informativo= ".$informativo ;
$a->autor = $id_usuario;
$db_auditoria->salvar($a);

header('Location: gerenciar_pagamentos_prestador.php?id='.$id_prestador);

