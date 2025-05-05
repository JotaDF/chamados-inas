<?php

require_once('./actions/ManterAgenda.php');
require_once('./dto/Agenda.php');

if (isset($_REQUEST['id']) && isset($_REQUEST['inicio']) && isset($_REQUEST['termino'])){
		
		
    $id = $_REQUEST['id'];
    $inicio = $_REQUEST['inicio'];
    $termino = $_REQUEST['termino'];

    $db_agenda = new ManterAgenda();
    $a = new Agenda();
    $a->id = $id;
    $a->inicio = date('Y/m/d H:i:s', strtotime($inicio));
    $a->termino = date('Y/m/d H:i:s', strtotime($termino));


    $sth = $db_agenda->salvarData($a);
    if ($sth == false) {
        echo 'Erro ao executar';
    }else{
        echo 'OK';
    }

}

