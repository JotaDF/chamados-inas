<?php

require_once('./actions/ManterLicitacao.php');
require_once('./dto/Licitacao.php');

$db_licitacao = new ManterLicitacao();
$licitacao = new Licitacao();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

if ($id > 0) {
    $licitacao = $db_licitacao->getLicitacaoPorId($id);
    $caminho = __DIR__.'/licitacoes/'.$licitacao->id.'_'.$licitacao->ano.'/';
    if (is_dir($caminho)) {
        $db_licitacao->delPasta($caminho);
    }
    $db_licitacao->excluir($id);
    header('Location: licitacoes.php');
} else {
    echo 'Falta de parâmetro!';
    header('Location: licitacoes.php');
}
