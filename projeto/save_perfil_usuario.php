<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterUsuario.php');
require_once('./dto/Usuario.php');

$db_usuario = new ManterUsuario();
$usuario = new Usuario();

$entrada       = $_POST['entrada'] ?? '';
$saidaAlmoco   = $_POST['saida_almoco'] ?? '';
$voltaAlmoco   = $_POST['volta_almoco'] ?? '';
$saida         = $_POST['saida'] ?? '';


$usuario->id                = isset($_POST['id']) ? $_POST['id'] : 0;
$usuario->whatsapp          = $_POST['whatsapp'];
$usuario->linkedin          = $_POST['linkedin'];
$usuario->aniversariantes   = $_POST['aniversariantes'];
$usuario->horario = implode(';', [$entrada, $saidaAlmoco, $voltaAlmoco, $saida]);
//echo $usuario->horario;
// print_r($_POST);
$db_usuario->salvarPerfil($usuario);

header('Location: perfil_usuario.php?id='.$usuario->id);

