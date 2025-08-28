<?php 
require_once("actions/ManterEapItem.php");

$id             = isset($_GET["id"]) ? $_GET["id"]   : 0;
$id_projeto     = isset($_GET["id_projeto"]) ? $_GET["id_projeto"] : 0;

$db_eap_item    = new ManterEapItem();


$resultado = $db_eap_item->excluir($id);
if($resultado) {
    header("Location: eap_item.php?id=" . $id_projeto);
    exit;
} else {
        header("Location: eap_item.php?id=" . $id_projeto);
    exit;
}