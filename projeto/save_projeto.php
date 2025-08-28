<?php
include 'actions/ManterProjeto.php';
$db_projeto = new ManterProjeto();
$caminho_dir = './arquivos_projeto/';
$p = new Projeto;
$id_projeto = isset($_POST['id_projeto']) ? $_POST['id_projeto'] : 0;

$p->id          = $id_projeto;
$p->nome        = $_POST['nome'];
$p->descricao   = $_POST['descricao'];
$p->tap         = html_entity_decode($_POST['tap']);
$p->orcamento   = $_POST['orcamento'];
$p->objetivo    = $_POST['objetivo'];

$resultado = $db_projeto->salvar($p);
if ($resultado) {
    $db_projeto->criaDirPorProjeto($p->id, $caminho_dir);
    header('Location: projeto.php');
} else {
    header('Location: projeto.php');
}