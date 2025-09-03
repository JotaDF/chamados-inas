<?php
require_once("actions/ManterCronograma.php");
$db_cronograma = new ManterCronograma();

$id_cronograma = $_POST["id_cronograma"];
$id_eap_item = $_POST["id_eap_item"];
$inicio_real = $_POST['inicio_real'] ? $_POST['inicio_real'] : "NULL";
$fim_real = $_POST['fim_real'] ? $_POST['fim_real'] : "NULL";
if ($inicio_real) {
    $resultado = $db_cronograma->iniciar($inicio_real, $id_cronograma);
    if ($resultado) {
        header("Location: cronograma.php?id=" . $id_eap_item);
    } else if ($fim_real) {
        $resultado = $db_cronograma->finalizar($fim_real, $id_cronograma);
        if ($resultado) {
            header("Location: cronograma.php?id=" . $id_eap_item);
        } else {
            header("Location: cronograma.php?id=" . $id_eap_item);
        }
    }
}