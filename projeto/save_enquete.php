<?php

require_once('./actions/ManterEnquete.php');
require_once('./dto/Enquete.php');

$db_enquete = new ManterEnquete();
$p = new Enquete();

$id        = isset($_POST['id']) ? $_POST['id'] : 0;
$descricao = isset($_POST['descricao']) ? html_entity_decode($_POST['descricao']) : '';
$p->id = $id;
$p->descricao = $descricao;
$p = $db_enquete->salvar($p); 

$criar_pasta = false;

if($id == 0 || $id==""){
    $criar_pasta = true;
}

if ($criar_pasta) {
    $caminho = __DIR__.'/enquete/folder_'. $e->id .'/';
    $db_enquete->addPasta($caminho);
}
header('Location: enquetes.php');

