<?php

require_once('./actions/ManterEvento.php');

$db_evento = new ManterEvento();

$id_evento = $_POST['id_evento'];
$id_usuario = $_POST['id_usuario'];

$db_evento->cancelarInscricao($id_evento, $id_usuario);
header('Location: perfil_usuario.php?id=' . $id_usuario);

