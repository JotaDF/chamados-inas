<?php

$arquivo = isset($_REQUEST['file']) ? $_REQUEST['file'] : "";
$numero = $_REQUEST['numero'];
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";;


if ($ano != "") {
    $caminho = __DIR__.'/contratos/'.$numero.'_'.$ano.'/';
    $filePath = $caminho . $arquivo;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Arquivo $file excluído com sucesso!";
    } else {
        echo "Arquivo não encontrado.";
    }
}

header('Location: gerenciar_arquivos_contrato.php?numero='.$numero . '&ano='.$ano);
