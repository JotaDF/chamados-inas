<?php


$manterSlaRegulacao = new ManterSlaRegulacao;
$regulacao = $manterSlaRegulacao->listaSlaRegulacaoTemporaria();

foreach ($regulacao as $r) {
    echo "<tr>";
    echo "<td>" . $r->autorizacao . "</td>";
    echo "<td>" . $r->tipo_guia . "</td>";
    echo "<td>" . $r->area . "</td>";
    echo "<td>" . $r->encaminhamento_manual . "</td>";
    echo "<td>" . $r->data_solicitacao_d . "</td>";
    echo "</tr>";
}