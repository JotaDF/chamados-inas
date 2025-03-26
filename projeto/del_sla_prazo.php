<?php 
include_once ('actions/ManterSlaPrazo.php');
$manterSlaPrazo = new ManterSlaPrazo();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if($id > 0) {
    $manterSlaPrazo->excluir($id);
    header('Location: prazos.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: prazos.php');
}