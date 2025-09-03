<?php 
require_once('actions/ManterPerfilProjeto.php');
require_once('dto/PerfilProjeto.php');

$p = new PerfilProjeto;

$id_perfil_projeto  = isset($_POST['id_perfil_projeto']) ? $_POST['id_perfil_projeto'] : 0;

$p->id   = $id_perfil_projeto;
$p->nome = $_POST['nome'];

$db_perfil_projeto   = new ManterPerfilProjeto();
$resultado           = $db_perfil_projeto->salvar($p);

if($resultado) {
    header('Location: perfil_projeto.php');
} else {
    var_dump($p);
}