<?php
require_once('actions/ManterSlaRegulacao.php');

$manterSlaRegulacao = new ManterSlaRegulacao;
$prazo = $manterSlaRegulacao->getTotaisPrazo();

foreach ($prazo as $p) {
    echo "<tr>";
    echo "<td>" .$p->fila . "</td>";
    if($p->atraso_1 == 0) {
        echo "<td><strong>" .$p->atraso_1 . "</strong></td>";
    } else {
        echo "<td style='color: #36A2EB'><strong>" .$p->atraso_1 . "</strong></td>";
    }
    echo "<td style='color: #FF6384'><strong>" .$p->atraso_0 . "</strong></td>";
    echo "</tr>";
}