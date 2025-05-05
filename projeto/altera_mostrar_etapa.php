<?php
require_once('./actions/ManterEtapa.php');

$db_etapa = new ManterEtapa();

$id = $_REQUEST['id'];

$mostrar = $_REQUEST['mostrar'];
if($mostrar == 1){
    $mostrar = 0;
 } else {
    $mostrar = 1;
 }
 
 $res = $db_etapa->mudaMostrar($id, $mostrar);
 echo true;
