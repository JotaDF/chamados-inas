<?php

require_once('./actions/ManterEnquete.php');

$db_enquete = new ManterEnquete();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
if ($id > 0) {
    if ($status == 0) {
        $db_enquete->despublicar($id);
    } else {
        $db_enquete->publicar($id);
    }
    header('Location: enquetes.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: enquetes.php');
}
