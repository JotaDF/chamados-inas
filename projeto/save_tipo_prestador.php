<?php

require_once('./actions/ManterTipoPrestador.php');
require_once('./dto/TipoPrestador.php');

$db_tipo_prestador = new ManterTipoPrestador();
$tp = new TipoPrestador();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$tipo = $_POST['tipo'];

$tp->id = $id;
$tp->tipo = $tipo;

$db_tipo_prestador->salvar($tp);
header('Location: tipos_prestadores.php');

