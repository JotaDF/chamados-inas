<?php

require_once('./actions/ManterLicitacao.php');
require_once('./dto/Licitacao.php');

$db_licitacao = new ManterLicitacao();
$licitacao = new Licitacao();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $db_licitacao->excluir($id);
    header('Location: licitacoes.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: licitacoes.php');
}
