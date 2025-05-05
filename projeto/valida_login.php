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

;
if($usuario = $db_login->logar($login, $senha)){
    $_SESSION['usuario'] = serialize($usuario);
    $_SESSION['editar'] = 1;
    if(isset($_SESSION['url_tmp'])){
	$url = $_SESSION['url_tmp'];
	$_SESSION['url_tmp'] = null;
	header('Location: '.$url);
    } else {
    	header('Location: index.php');
    }
}  else {
    header('Location: form_login.php?error=1'); 
}


