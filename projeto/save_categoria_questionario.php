<?php

include_once('actions/ManterQuestCategoriaPergunta.php');
require_once('./dto/QuestCategoriaPergunta.php');

$db_notificacao = new ManterNotificacao();
$c = new QuestCategoriaPergunta();

$manterCategoria = new ManterQuestCategoriaPergunta();

$id  = $_REQUEST['id'];
$id_questionario = $_REQUEST['id_questionario'];
$nome = isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : '';
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 1;

$c->id = $id;
$c->nome = $nome;   
$c->questionario = $id_questionario;
if ($op == 1) {
    $manterCategoria->salvar($id_equipe,$id_usuario);
} else {
    $manterCategoria->excluir($id);
}
header('Location: quest_gerenciar_categorias_questionario.php?id='.$id_questionario);
