<?php

require_once('./actions/ManterCartaRecursada.php');

$db_glosa = new ManterCartaRecursada();

$informativo = $_REQUEST['informativo'];
$id_prestador = $_REQUEST['id_prestador'];

echo $db_glosa->verificaInformativo($id_prestador,$informativo);
