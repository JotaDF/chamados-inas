<?php

require_once('./actions/ManterEnquete.php');

$db_enquete = new ManterEnquete();

$id_opcao = $_REQUEST['id'];
$id_enquete = $_REQUEST['id_enquete'];
if ($id_opcao > 0) {
    $db_enquete->delOpcao($id_opcao);
    header('Location: gerenciar_opcoes_enquete.php?id='.$id_enquete);
} else {
    echo 'Falta de parâmetro!';
    header('Location: gerenciar_opcoes_enquete.php?id='.$id_enquete);
}
