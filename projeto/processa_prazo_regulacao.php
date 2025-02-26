<?php
require_once('actions/ManterSlaRegulacao.php');

if(isset($_POST['update'])) {
    $manterSlaRegulacao = new ManterSlaRegulacao;
    $regulacao = $manterSlaRegulacao->listarSlaRegulacao();
    $hoje = time();
    
    foreach ($regulacao as $r) {
        $quantidadeDiasUteis = $manterSlaRegulacao->getDiasUteis($r->data_solicitacao_t, $hoje);
        $tempo_util = $quantidadeDiasUteis * 86400;
        $prazo_segundos = $manterSlaRegulacao->getPrazoGuia($r->tipo_guia, $r->fila);
        $data_final = $tempo_util - $prazo_segundos;
        if ($data_final > 0) {
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 0);
        } else {
            $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 1);
        }
    }
}
header('Location: enviar_arquivo_sla_regulacao.php?msg=3');
exit();