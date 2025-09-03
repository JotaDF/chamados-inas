<?php 
require_once("actions/ManterEapItem.php");
require_once("dto/EapItem.php");


// var_dump($_POST);
$id             = isset($_POST["id"]) ? $_POST["id"]   : 0;
$id_projeto     = isset($_POST["id_projeto"]) ? $_POST["id_projeto"] : 0;
$nome           = $_POST["nome"];
$id_eap_item    = $_POST['id_eap_item_pai'] !== "" ? $_POST['id_eap_item_pai'] : "null";

$eap               = new EapItem;
$eap->id           = $id;
$eap->projeto      = $id_projeto;
$eap->nome         = $nome;
$eap->id_eap_item  = $id_eap_item;

$db_eap            = new ManterEapItem();

$resultado = $db_eap->salvar($eap);
if($resultado) {
    header("Location: eap_item.php?id=" . $id_projeto);
    exit;
} else {
    header("Location: eap_item.php?id=" . $id_projeto);
    exit;
}

