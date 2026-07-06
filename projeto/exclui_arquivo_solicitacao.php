<?php

header('Content-Type: application/json');

require_once('actions/ManterSolicitacao.php');

$manterSolicitacao = new ManterSolicitacao();

$sucesso = $manterSolicitacao->excluiArquivoSolicitacao(
    $_POST['pasta'],
    $_POST['arquivo']
);

echo json_encode([
    'sucesso' => $sucesso
]);