<?php
include 'actions/ManterProjeto.php';
$db_projeto = new ManterProjeto();
$p = new Projeto;

$p->id = isset($_POST['id_projeto']) ? $_POST['id_projeto'] : 0;
$p->nome = $_POST['nome'];
$p->descricao = $_POST['descricao'];
$p->tap = $_POST['tap'];
$p->orcamento = $_POST['orcamento'];
$p->status = $_POST['status'];
$p->objetivo = $_POST['objetivo'];
$resultado = $db_projeto->salvar($p);
if ($resultado) {
    header('Location: projeto.php');
}