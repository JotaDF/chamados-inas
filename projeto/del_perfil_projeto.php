<?php 
require_once('actions/ManterPerfilProjeto.php');
$id_perfil_projeto = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

$pf  = new ManterPerfilProjeto();
$resultado = $pf->excluir($id_perfil_projeto);

if($resultado) {
    header('Location: perfil_projeto.php');
} else {
    echo 'Erro ao excluir o perfil do projeto.';
    header('Location: perfil_projeto.php');
}