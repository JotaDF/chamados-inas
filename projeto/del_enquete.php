<?php

require_once('./actions/ManterEnquete.php');

$db_enquete = new ManterEnquete();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_enquete->excluir($id);
    header('Location: enquetes.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: enquetes.php');
}
