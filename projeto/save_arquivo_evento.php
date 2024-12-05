<?php

$id = $_REQUEST['id'];

if(!empty($_FILES['file'])){
    $caminho = "eventos/folder_" . $id . "/";
    $arquivo = basename($_FILES['file']['name']);
    $targetFilePath = $caminho . $arquivo;
    echo $targetFilePath;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
        echo 'Arquivo enviado';
    }
}

header('Location: gerenciar_folder_evento.php?id='.$id);