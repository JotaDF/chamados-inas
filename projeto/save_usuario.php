<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterUsuario.php');
require_once('./dto/Usuario.php');

$db_usuario = new ManterUsuario();
$usuario = new Usuario();

$usuario->id                = isset($_POST['id']) ? $_POST['id'] : 0;
$usuario->login             = addslashes($_POST['login']);
$usuario->nome              = addslashes($_POST['nome']);
$usuario->matricula         = $_POST['matricula'];
$usuario->cargo             = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$usuario->email             = $_POST['email'];
$usuario->descricao_lotacao = $_POST['descricao_lotacao'];
$usuario->simbolo_cargo     = $_POST['simbolo_cargo'];
$usuario->cargo_efetivo     = $_POST['cargo_efetivo'];
$usuario->codigo_lotacao    = $_POST['codigo_lotacao'];
$usuario->nascimento        = isset($_POST['nascimento']) ? strtotime($_POST['nascimento']) : '';
$usuario->whatsapp          = $_POST['whatsapp'];
$usuario->linkedin          = $_POST['linkedin'];
$usuario->setor             = $_POST['setor'];
$usuario->cpf               = $_POST['cpf'];

//print_r($usuario);
$db_usuario->salvar($usuario);



    header('Location: usuarios.php');

