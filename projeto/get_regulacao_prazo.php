<?php
require_once('actions/ManterSlaRegulacao.php');

$manterSlaRegulacao = new ManterSlaRegulacao;
$prazo = $manterSlaRegulacao->getTotaisPrazo();
$array_filas = array();
foreach ($prazo as $p) {
    $array_filas[] = $p->fila;
}
$prazoZerado = $manterSlaRegulacao->getTotaisPrazoZerado($array_filas);

$resultado = array_merge($prazo, $prazoZerado);
$TodasFilas = array_values($resultado);

foreach ($TodasFilas as $p) {
    echo "<tr>";
    echo "<td><a href='painel_atrasados.php?fila_todos=" . urlencode($p->fila) . "'>" . $p->fila . "</a></td>";
    if($p->no_atraso_count == 0) {
        echo "<td><a href='painel_atrasados.php?fila=" . urlencode($p->fila) . "'<strong>" .$p->no_atraso_count . "</strong></td>";
    } else {
        echo "<td><a href='painel_atrasados.php?fila=" . urlencode($p->fila) . "'  style='color: #36A2EB'><strong>" .$p->no_atraso_count . "</strong></td>";
    }
    echo "<td><strong><a href='painel_atrasados.php?fila_a=" . urlencode($p->fila) . "' style='color: #FF6384'>" .$p->atraso_count . "</strong></td>";
    echo "</tr>";
}
