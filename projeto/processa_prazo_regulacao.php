<?php
include('actions/ManterSlaRegulacao.php');
$manterSlaRegulacao = new ManterSlaRegulacao;
$regulacao = $manterSlaRegulacao->listarSlaRegulacao();
$hoje = time();

foreach ($regulacao as $r) {
    $quantidadeDiasUteis = getDiasUteis($r->data_solicitacao_t, $hoje);
    $tempo_util = $quantidadeDiasUteis * 86400;
    $prazo_segundos = $manterSlaRegulacao->getPrazoGuia($r->tipo_guia, $r->fila);
    $data_final = $tempo_util - $prazo_segundos;
    echo "Autorização: " . $r->autorizacao. " Data final: " . $data_final . " Hoje: ". $hoje . " Data AT: " . $r->data_solicitacao_t . "<br>";
    if ($data_final > 0) {
        $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 0);
    } else {
        $manterSlaRegulacao->atualizaAtraso($r->autorizacao, 1);
    }
}


// 1740063581;
// 1740495581
// 1740495649