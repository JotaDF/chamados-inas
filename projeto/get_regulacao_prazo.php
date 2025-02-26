<?php
require_once('actions/ManterSlaRegulacao.php');

$manterSlaRegulacao = new ManterSlaRegulacao;
$prazo = $manterSlaRegulacao->getTotaisPrazo();

foreach ($prazo as $p) {
    echo "<tr>";
    echo "<td>" .$p->fila . "</td>";
    echo "<td>" .$p->atraso_1 . "</td>";
    echo "<td>" .$p->atraso_0 . "</td>";
    echo "</tr>";
}