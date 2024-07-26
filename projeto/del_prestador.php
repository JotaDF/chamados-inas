<?php

require_once('./actions/ManterPrestador.php');
require_once('./dto/Prestador.php');

$db_prestador = new ManterPrestador();
$prestador = new Prestador();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$db_prestador->excluir($id);

header('Location: prestadores.php');

