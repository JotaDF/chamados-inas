<?php

include_once('actions/ManterQuestCategoriaPergunta.php');

$manterCategoria = new ManterQuestCategoriaPergunta();

$id_pergunta  = $_REQUEST['id_pergunta'];
$id_categoria  = $_REQUEST['id_categoria'];
$id_questionario = $_REQUEST['id_questionario'];
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;

$c->id = $id;
$c->nome = $nome;   
$c->questionario = $id_questionario;
if ($op == 1) {
    $manterCategoria->addPergunta($id_categoria,$id_pergunta);
} else {
    $manterCategoria->delPergunta($id_categoria,$id_pergunta);
}
header('Location: quest_gerenciar_perguntas_categoria.php?id_categoria='.$id_categoria.'&id_questionario='.$id_questionario);
