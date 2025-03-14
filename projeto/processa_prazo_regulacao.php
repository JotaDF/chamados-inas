<?php
require_once('actions/ManterSlaRegulacao.php');
if (isset($_POST['update']) || isset($_POST['update_painel'])) {
    $manterSlaRegulacao = new ManterSlaRegulacao;
    
    $hoje = time();
    
    // Chama os métodos para atualizar as informações
    $manterSlaRegulacao->atualizaAutorizados();
    $manterSlaRegulacao->atualizaNovosSla();
    $manterSlaRegulacao->limpaSlaTemporaria();

    $regulacao = $manterSlaRegulacao->listarSlaRegulacaoNaoAutorizados();
    // Processa cada regulacao
    foreach ($regulacao as $r) {
        $quantidadeDiasUteis = $manterSlaRegulacao->getDiasUteis($r->data_solicitacao_t, $hoje);
        $tempo_util = $quantidadeDiasUteis * 86400; // 1 dia = 86400 segundos
        $prazo_segundos = $manterSlaRegulacao->getPrazoGuia($r->tipo_guia, $r->fila);
        $data_final = $tempo_util - $prazo_segundos;
        if ($data_final > 0) {
            $diasAtraso = ceil($data_final / 86400); 
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao,  $diasAtraso); // Atualiza como dentro do prazo
        } else {
            // Caso esteja dentro do prazo
            $diasAtraso = 0;
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao, $diasAtraso); // Atualiza como dentro do prazo
        }
    }
}
header('Location: painel_regulacao_prazo.php');
