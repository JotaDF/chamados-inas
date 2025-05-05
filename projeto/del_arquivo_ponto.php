<?php

$arquivo = isset($_REQUEST['file']) ? $_REQUEST['file'] : "";
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : "";

if(strlen(trim($mes)) < 2){
  $mes = "0".$mes;
}

if ($ano != "") {
    $caminho = "ponto/" . $ano . "/" . $mes . "/";
	echo $caminho;
    $filePath = $caminho . $arquivo;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Arquivo $file excluído com sucesso!";
    } else {
        echo "Arquivo não encontrado.";
    }
}

//header('Location: gerenciar_arquivos_ponto.php');
