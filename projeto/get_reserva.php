<?php
//	include_once('actions/ManterReserva.php'); 
	
//	$manterReserva = new ManterReserva();
	
//	$lista = $manterReserva->listar();
    $reservas=[];
//    foreach ($lista as $obj) {
        $reservas[] = [
            'id'=>  1,
            'title'=>  'Sala de reuniões com equipamento!',
            'color'=>  '#FF5631',
            'start'=>  '2024-04-12 10:30',
            'end'=>  '2024-04-12 11:30',

        ];
//    }

    echo json_encode($reservas);
