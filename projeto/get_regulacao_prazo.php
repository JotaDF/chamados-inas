<?php
require_once('actions/ManterSlaRegulacao.php');

$manterSlaRegulacao = new ManterSlaRegulacao;
$prazo = $manterSlaRegulacao->getTotaisPrazo();

foreach ($prazo as $p) {
    echo "<tr>";
    echo "<td><a href='painel_atrasados.php?fila_a=" . urlencode($p->fila) . "'>" . $p->fila . "</a></td>";
    if($p->no_atraso_count == 0) {
        echo "<td><a href='painel_atrasados.php?fila_a=" . urlencode($p->fila) . "'<strong>" .$p->no_atraso_count . "</strong></td>";
    } else {
        echo "<td><a href='painel_atrasados.php?fila_a=" . urlencode($p->fila) . "'  style='color: #36A2EB'><strong>" .$p->no_atraso_count . "</strong></td>";
    }
    echo "<td><strong><a href='painel_atrasados.php?fila_a=" . urlencode($p->fila) . "' style='color: #FF6384'>" .$p->atraso_count . "</strong></td>";
    echo "</tr>";
}