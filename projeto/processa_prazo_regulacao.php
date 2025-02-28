<?php
require_once('actions/ManterSlaRegulacao.php');
if (isset($_POST['update']) || isset($_POST['update_painel'])) {
    $manterSlaRegulacao = new ManterSlaRegulacao;
    $regulacao = $manterSlaRegulacao->listarSlaRegulacao();
    $hoje = time();
    $manterSlaRegulacao->atualizaAutorizados();
    $manterSlaRegulacao->atualizaNovosSla();
    $manterSlaRegulacao->limpaSlaTemporaria();
    foreach ($regulacao as $r) {
        $quantidadeDiasUteis = $manterSlaRegulacao->getDiasUteis($r->data_solicitacao_t, $hoje);
        $tempo_util = $quantidadeDiasUteis * 86400; // Converte dias úteis para segundos
        $prazo_segundos = $manterSlaRegulacao->getPrazoGuia($r->tipo_guia, $r->fila);
        $data_final = $tempo_util - $prazo_segundos;

        // Verifica se o prazo foi cumprido
        if ($data_final > 0) {
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 0); // Atualiza como fora do prazo
        } else {
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 1); // Atualiza como dentro do prazo
        }
    }

   
    if (isset($_POST['update_painel'])) {
        header('Location: painel_regulacao_prazo.php'); // Página do painel
    } else {
        header('Location: enviar_arquivo_sla_regulacao.php?msg=3'); // Página de envio de arquivo com mensagem
    }

    exit();
}
