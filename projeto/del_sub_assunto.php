<?php

require_once('./actions/ManterSubAssunto.php');
require_once('./dto/SubAssunto.php');

$db_sub_assunto = new ManterSubAssunto();
$sub_assunto= new SubAssunto();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_sub_assunto->excluir($id);
    header('Location: sub_assuntos.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: sub_assuntos.php');
}
