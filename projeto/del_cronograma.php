<?php 
require_once "actions/ManterCronograma.php";

$id_cronograma = $_GET["id"];
$id_eap_item  = $_GET["eap"];

$db_cronograma  = new ManterCronograma();

$resultado = $db_cronograma->excluir($id_cronograma);
if($resultado) {
    header("Location: cronograma.php?id=" . $id_eap_item);
} else {
    header("Location: cronograma.php?id=" . $id_eap_item);
}