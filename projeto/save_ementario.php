<?php

require_once('./actions/ManterEmentario.php');
require_once('./dto/Ementario.php');

$db_ementario = new ManterEmentario();
$e = new Ementario();

$id         = isset($_POST['id']) ? $_POST['id'] : 0;
$processo_sei     = isset($_POST['processo_sei']) ? $_POST['processo_sei'] : '';
$doc_sei  = isset($_POST['doc_sei']) ? $_POST['doc_sei'] : '';
$nota_juridica       = isset($_POST['nota_juridica']) ? $_POST['nota_juridica'] : '';
$ementa       = isset($_POST['ementa']) ? $_POST['ementa'] : '';
$usuario   = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '0';

$e->id              = $id;
$e->processo_sei    = $processo_sei;
$e->doc_sei         = $doc_sei;
$e->nota_juridica   = $nota_juridica;
$e->ementa          = html_entity_decode($ementa);
$e->usuario         = $usuario;

$criar_pasta = false;

$e = $db_ementario->salvar($e);

header('Location: ementario.php');

