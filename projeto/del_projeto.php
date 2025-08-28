<?php
require_once './actions/ManterProjeto.php';
require_once './dto/Projeto.php';
$caminho_dir = './arquivos_projeto/';
$db_projeto = new ManterProjeto();
$p = new Projeto;
$id_projeto = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id_projeto > 0) {
    $resultado = $db_projeto->excluir($id_projeto);
    if($resultado) {
      $db_projeto->excluirDirProjeto($id_projeto, $caminho_dir);
    }
    header('Location: projeto.php');
}