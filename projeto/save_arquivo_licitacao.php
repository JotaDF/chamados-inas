<?php

$id = $_REQUEST['id'];
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
//echo $numero . " # " .$ano;
//exit;
if(!empty($_FILES['file'])){
    $caminho = "licitacoes/" . $id . "_" . $ano . "/";
    $arquivo = basename($_FILES['file']['name']);
    $targetFilePath = $caminho . $arquivo;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
        echo 'Arquivo enviado';
    }
}

header('Location: gerenciar_arquivos_licitacao.php?id='.$id.'&ano='.$ano);
