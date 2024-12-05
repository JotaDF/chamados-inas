<?php

require_once('./actions/ManterEvento.php');

$db_evento = new ManterEvento();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
if ($id > 0) {
    if ($status == 0) {
        $db_evento->despublicar($id);
    } else {
        $db_evento->publicar($id);
    }
    header('Location: eventos.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: eventos.php');
}
