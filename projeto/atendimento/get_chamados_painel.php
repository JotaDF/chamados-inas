<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
    include_once('../actions/ManterFila.php');
    $manterFila = new ManterFila();
	
	$lista = $manterFila->getChamadosPainel();

    echo json_encode($lista);
