<?php

$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
$mes = isset($_REQUEST['mes']) ? $_REQUEST['mes'] : "";

if(!empty($_FILES['file'])){
    $caminho = "ponto/" . $ano . "/" . $mes . "/";
    $arquivo = basename($_FILES['file']['name']);
    $targetFilePath = $caminho . $arquivo;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
        echo 'Arquivo enviado';
    }
}

header('Location: gerenciar_arquivos_ponto.php');