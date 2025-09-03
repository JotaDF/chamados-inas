<?php 
require_once("actions/ManterProjeto.php");
require_once("dto/ProjetoUsuario.php");
$id_usuario        = $_GET['id_usuario'] ? $_GET['id_usuario'] : 0;
$id_perfil_projeto = $_GET['id_perfil'] ? $_GET['id_perfil'] : 0;
$id_projeto        = $_GET['id_projeto'] ? $_GET['id_projeto'] : 0;

$pu = new ProjetoUsuario();
$pu->id_usuario = $id_usuario;
$pu->id_perfil_projeto = $id_perfil_projeto;
$pu->id_projeto = $id_projeto;

$db_projeto = new ManterProjeto();
if($id_usuario > 0 || $id_perfil_projeto > 0) {
    $db_projeto->removeProjetoUsuario($pu);
    header("Location: gerenciar_projeto_usuario.php?id=$id_projeto");
    exit;
} else {
    echo 'Falta parametro!';
    header("Location: gerenciar_projeto_usuario.php?id=$id_projeto");
    exit;
}