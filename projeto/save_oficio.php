<?php

require_once('./actions/ManterOficio.php');
require_once('./dto/Oficio.php');

$db_oficio = new ManterOficio();
$o = new Oficio();

$o->id = isset($_POST['id']) ? $_POST['id'] : 0;
$o->setor = $_POST['setor'];
$o->usuario = $_POST['id_usuario'];
$o->processo = $_POST['processo'];
$o->link_sei = $_POST['link_sei'];
$o->numero = $_POST['numero'];
$o->assunto = $_POST['assunto'];
$o->origem = $_POST['origem'];
$o->destino = $_POST['destino'];    

$db_oficio->salvar($o);
header('Location: oficios.php');

