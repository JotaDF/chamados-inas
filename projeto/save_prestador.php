<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterPrestador.php');
require_once('./dto/Prestador.php');

$db_prestador = new ManterPrestador();
$prestador = new Prestador();

$prestador->id              = isset($_POST['id']) ? $_POST['id'] : 0;
$prestador->cnpj            = $_POST['cnpj'];
$prestador->nome_fantasia   = addslashes($_POST['nome_fantasia']);
$prestador->razao_social    = addslashes($_POST['razao_social']);
$prestador->telefone        = isset($_POST['telefone']) ? $_POST['telefone'] : '';
$prestador->tipo_prestador  = $_POST['tipo_prestador'];
$prestador->credenciado     = $_POST['credenciado'];
$prestador->ativo           = isset($_POST['ativo']) ? $_POST['ativo'] : 1;

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 0;
$retorno = 'prestadores.php';
if($op > 0){
    $retorno = 'contratos.php';
}
//print_r($prestador);
$db_prestador->salvar($prestador);

header('Location: '. $retorno);

