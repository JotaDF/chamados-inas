<?php

require_once('./actions/ManterPrestador.php');
require_once('./dto/Prestador.php');

$db_prestador = new ManterPrestador();
$prestador = new Prestador();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 0;

$db_prestador->excluir($id);
$retorno = 'prestadores.php';
if($op > 0){
    $retorno = 'contratos.php';
}
header('Location: '. $retorno);

