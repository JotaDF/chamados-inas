<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once('./actions/ManterRecepcao.php');
require_once('./dto/Recepcao.php');

$db_recepcao = new ManterRecepcao();
$r = new Recepcao();


$r->id = isset($_POST['id']) ? $_POST['id'] : 0;
$r->visitante =  isset($_POST['visitante']) ? $_POST['visitante'] : '';
$r->empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
$r->horario = isset($_POST['horario']) ? $_POST['horario'] : '';
$r->setor = isset($_POST['setor']) ? $_POST['setor'] : '';
$r->recebido_por = isset($_POST['recebido_por']) ? $_POST['recebido_por'] : '';
$r->assunto = isset($_POST['assunto']) ? $_POST['assunto'] : '';
$r->usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';

print_r($r);

$db_recepcao->salvar($r);
header('Location: recepcoes.php');

