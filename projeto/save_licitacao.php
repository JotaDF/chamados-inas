<?php

require_once('./actions/ManterLicitacao.php');
require_once('./dto/Licitacao.php');

$db_licitacao = new ManterLicitacao();
$l = new Licitacao();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$modalidade = $_POST['modalidade'];
$certame = $_POST['certame'];
$ano = $_POST['ano'];

$l->id = $id;
$l->modalidade = $modalidade;
$l->certame = $certame;
$l->ano = $ano;

$l = $db_licitacao->salvar($l);

$caminho = __DIR__.'/licitacoes/'.$l->id.'_'.$l->ano.'/';
$db_licitacao->addPasta($caminho);

header('Location: licitacoes.php');

