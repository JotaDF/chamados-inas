<?php

require_once('./actions/ManterEvento.php');
require_once('./dto/Evento.php');

$db_evento = new ManterEvento();
$e = new Evento();

$id         = isset($_POST['id']) ? $_POST['id'] : 0;
$titulo     = isset($_POST['titulo']) ? $_POST['titulo'] : '';
$descricao  = isset($_POST['descricao']) ? $_POST['descricao'] : '';
$data       = isset($_POST['data']) ? $_POST['data'] : '';
$hora       = isset($_POST['hora']) ? $_POST['hora'] : '';
$inscreve   = isset($_POST['inscreve']) ? $_POST['inscreve'] : '0';

$e->id          = $id;
$e->titulo      = $titulo;
$e->descricao   = $descricao;
$e->data        = $data;
$e->hora        = $hora;
$e->inscreve    = $inscreve;

$db_evento->salvar($e);

header('Location: eventos.php');

