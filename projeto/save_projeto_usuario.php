<?php 
require_once("actions/ManterProjetoUsuario.php");
require_once("dto/ProjetoUsuario.php");
$id_usuario = $_POST['id_usuario'] ? $_POST['id_usuario'] : 0;
$id_projeto = $_POST['id_projeto'] ? $_POST['id_projeto'] : 0;
$id_perfil_projeto = $_POST['id_perfil_projeto'] ? $_POST['id_perfil_projeto'] : 0;

$p = new ProjetoUsuario;

$p->id_usuario        = $id_usuario;
$p->id_projeto        = $id_projeto;
$p->id_perfil_projeto = $id_perfil_projeto;

$db_projeto_usuario = new ManterProjetoUsuario();
$resultado = $db_projeto_usuario->salvar($p);

if($resultado) {
   header("Location: gerenciar_projeto_usuario.php?id=" . $id_projeto);
   exit;
} 