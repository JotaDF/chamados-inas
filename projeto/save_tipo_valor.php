<?php

require_once('./actions/ManterTipoValor.php');
require_once('./dto/TipoValor.php');

$db_tipo_valor = new ManterTipoValor();
$s = new TipoValor();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$tipo = $_POST['tipo'];

$s->id = $id;
$s->tipo = $tipo;

$db_tipo_valor->salvar($s);
header('Location: tipos_valores.php');

