<?php 
require_once("actions/ManterArquivo.php");
$db_arquivo = new ManterArquivo();
$id_arquivo  = isset($_REQUEST['id'])      ? $_REQUEST['id'] : 0;
$id_projeto  = isset($_REQUEST['projeto']) ? $_REQUEST['projeto'] :0;
$url_arquivo  = isset($_REQUEST['url'])    ? $_REQUEST['url'] : "";


if($id_arquivo > 0) {
    $excluir_arquivo = $db_arquivo->removeArquivo($url_arquivo);
    if($excluir_arquivo) {
        $excluir      = $db_arquivo->excluir($id_arquivo);
        header("Location: arquivo_projeto.php?id=" . $id_projeto);
        exit;
    } else {
        header("Location: arquivo_projeto.php?id=" . $id_projeto);
        exit;
    }
}
