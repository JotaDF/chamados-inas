<?php

require_once('./actions/ManterLicitacao.php');
require_once('./dto/Licitacao.php');

$db_licitacao = new ManterLicitacao();
$p = new Licitacao();

$id = isset($_POST['id']) ? $_POST['id'] : 0;
$modalidade = $_POST['modalidade'];
$certame = $_POST['certame'];
$ano = $_POST['ano'];

$p->id = $id;
$p->modalidade = $modalidade;
$p->certame = $certame;
$p->ano = $ano;

$caminho = __DIR__.'/contratos/'.$id.'_'.$ano.'/';
$db_licitacao->salvar($p);
$db_licitacao->addPasta($caminho);

header('Location: licitacoes.php');

