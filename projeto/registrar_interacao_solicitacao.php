<?php

require_once('./actions/ManterInteracaoSolicitacao.php');
require_once('./actions/ManterNotificacao.php');
require_once('./actions/ManterSolicitacao.php');

require_once('./dto/Notificacao.php');
require_once('./dto/Solicitacao.php');

$db_interacao = new ManterInteracaoSolicitacao();
$db_solicitacao = new ManterSolicitacao();
$db_notificacao = new ManterNotificacao();

$s = new Solicitacao();
$n = new Notificacao();

// Dados da requisição
$texto = $_POST['texto'];
$id_usuario = $_POST['id_usuario'];
$id_solicitacao = $_POST['id_solicitacao'] ?? 0;
$id_setor = $_POST['id_setor'] ?? 0;
$finalizar = $_POST['finalizar'] ?? 0;

// Verifica se houve upload de anexos
$possui_anexos = in_array(UPLOAD_ERR_OK, $_FILES['anexos']['error'], true);

$diretorio = $_POST['diretorio'] . DIRECTORY_SEPARATOR . 'interacoes';

// Registra a interação
$id_interacao = $db_interacao->registrarInteracao(
    $texto,
    $id_solicitacao,
    $id_usuario,
    $possui_anexos
);

// Processa os anexos
if ($possui_anexos) {
    $arquivos = $db_solicitacao->processaAnexos($_FILES['anexos']);
    $db_solicitacao->atualizaColunaAnexo($id_solicitacao);
    $db_solicitacao->armazenaAnexosPorInteracao(
        $arquivos,
        $diretorio,
        $id_interacao
    );
}

$notificado = false;

// Finaliza a solicitação
if ($finalizar) {
    $db_solicitacao->concluir($id_solicitacao);
    $db_interacao->registrarInteracao(
        "Solicitação foi concluída!",
        $id_solicitacao,
        $id_usuario,
        false
    );

    $notificado = $db_notificacao->notificarConclusaoSolicitacao(
        $id_usuario,
        $id_solicitacao,
        $id_setor
    );
}

// Notificação de nova interação
if (!$notificado) {
    // Registrando notificação
    $db_notificacao->notificarUsuario(
        "Nova interação na solicitação!",
        "gerenciar_interacoes_solicitacao.php?id=" . $id_solicitacao,
        "interacao",
        $id_usuario
    );
}

header('Location: gerenciar_interacoes_solicitacao.php?id=' . $id_solicitacao);