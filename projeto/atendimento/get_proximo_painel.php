<?php
    include_once('../actions/ManterFila.php');
    $manterFila = new ManterFila();
	
	$lista = $manterFila->getChamadosPainel();

    echo json_encode($lista);
