<?php


require_once('./actions/Login.php');
require_once('./dto/Usuario.php');

$db_login = new Login();
$usuario = new Usuario();


// Inicia sessao
session_start();

// Recupera o login
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
// Recupera a senha
$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : FALSE;

if($usuario = $db_login->logar($login, $senha)){
    $res = array("res" => true, "nome" => $usuario->nome, "matricula" => $usuario->matricula);   
}  else {
    $res = array("res" => false);
}
echo json_encode($res);

