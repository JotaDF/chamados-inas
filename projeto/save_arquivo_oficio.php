<?php

$id = $_REQUEST['id'];
//echo "ID: " . $id ;
if(!empty($_FILES['file'])){
    $caminho = "oficios/arquivo_" . $id . "/";
    $arquivo = basename($_FILES['file']['name']);
    $targetFilePath = $caminho . $arquivo;
    //echo $targetFilePath;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
        echo 'Arquivo enviado';
    }
}

header('Location: gerenciar_arquivo_oficio.php?id='.$id);