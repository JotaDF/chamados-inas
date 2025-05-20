<?php
require_once './actions/ManterQuestEscala.php';

if ($_SERVER['REQUEST_METHOD']) {
    $id  =  $_REQUEST['id'] ? $_REQUEST['id'] : 0;

    $manterQuestEscala = new ManterQuestEscala();

    if ($id > 0) {
        $manterQuestEscala->excluir($id);
        header('Location: quest_escala.php?msg=10');
        exit;
    }
}