<?php

$arquivo = isset($_REQUEST['file']) ? $_REQUEST['file'] : "";
$id = $_REQUEST['id'];
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";;


if ($ano != "") {
    $caminho = __DIR__.'/licitacoes/'.$id.'_'.$ano.'/';
    $filePath = $caminho . $arquivo;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Arquivo $file excluído com sucesso!";
    } else {
        echo "Arquivo não encontrado.";
    }
}

header('Location: gerenciar_arquivos_licitacao.php?id='.$id . '&ano='.$ano);
