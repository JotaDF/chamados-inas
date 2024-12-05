<?php

$arquivo = isset($_REQUEST['file']) ? $_REQUEST['file'] : "";
$id = $_REQUEST['id'];

if (isset($id)) {
    $caminho = __DIR__.'/eventos/folder_'.$id.'/';
    $filePath = $caminho . $arquivo;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Arquivo $file excluído com sucesso!";
    } else {
        echo "Arquivo não encontrado.";
    }
}

header('Location: gerenciar_folder_evento.php?id='.$id);
