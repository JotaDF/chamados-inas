<?php 
require_once('actions/ManterProjeto.php');
require_once('actions/ManterArquivo.php');
require_once('dto/Arquivo.php');
$manterProjeto = new ManterProjeto();
$manterArquivo = new ManterArquivo();
$a             = new Arquivo();
$id_projeto    = $_POST['id_projeto'];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['arquivo'])) {
     $resultado = $manterArquivo->uploadArquivo($_FILES['arquivo'], $id_projeto);
     if($resultado) {
        header('Location: arquivo_projeto.php?id=' . $id_projeto);
        exit;
     } else {
        echo 'falta parametros';
        header('Location: arquivo_projeto.php?id=' . $id_projeto);
        exit;
     }
     
    }
}
