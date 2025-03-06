<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterUsuario.php');
require_once('./dto/Usuario.php');

$db_usuario = new ManterUsuario();
$usuario = new Usuario();

$usuario->id                = isset($_POST['id']) ? $_POST['id'] : 0;
$usuario->whatsapp          = $_POST['whatsapp'];
$usuario->linkedin          = $_POST['linkedin'];
$usuario->aniversariantes   = $_POST['aniversariantes'];

//print_r($usuario);
$db_usuario->salvarPerfil($usuario);

header('Location: perfil_usuario.php?id='.$usuario->id);

