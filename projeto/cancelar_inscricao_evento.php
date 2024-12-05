<?php

require_once('./actions/ManterEvento.php');

$db_evento = new ManterEvento();

$id_evento = $_REQUEST['id_evento'];
$id_usuario = $_REQUEST['id_usuario'];

$db_evento->cancelarInscricao($id_evento, $id_usuario);
header('Location: index.php');
