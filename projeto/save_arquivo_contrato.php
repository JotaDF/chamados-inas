<?php

$numero = isset($_REQUEST['numero']) ? $_REQUEST['numero'] : "";
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
//echo $numero . " # " .$ano;
//exit;
if(!empty($_FILES['file'])){
    $caminho = "contratos/" . $numero . "_" . $ano . "/";
    $arquivo = basename($_FILES['file']['name']);
    $targetFilePath = $caminho . $arquivo;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
        echo 'Arquivo enviado';
    }
}

header('Location: gerenciar_arquivos_contrato.php?numero='.$numero.'&ano='.$ano);
