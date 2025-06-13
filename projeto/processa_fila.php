<?php
include_once('actions/ManterSlaRegulacao.php');
$manterRegulacao = new ManterSlaRegulacao;
$atraso = isset($_GET['fila_a']);
$noprazo = isset($_GET['fila']);
$todos = isset($_GET['fila_todos']);


if ($atraso) {
    $fila = $_GET['fila_a'];
    $regulacao = $manterRegulacao->listaSlaRegulacaoAtrasado($fila);
} else if ($noprazo) {
    $prazo = $_GET['fila'];
    echo "Você está vendo: " . $prazo;
    $regulacao = $manterRegulacao->listaSlaRegulacaoNoPrazo($prazo);
} else if ($todos) {
    $todos = $_GET['fila_todos'];
    echo $todos;
    $regulacao = $manterRegulacao->listarSlaRegulacao($todos);
}

foreach ($regulacao as $r) {
    echo "<tr>";
    echo "<td>" . $r->autorizacao . "</td>";
    echo "<td>" . $r->tipo_guia . "</td>";
    echo "<td>" . $r->area . "</td>";
    echo "<td>" . $r->fila . "</td>";

    if ($r->encaminhamento_manual == 1) {
        echo "<td> SIM </td>";
    } else {
        echo "<td> NÃO</td>";
    }
    echo "<td>" . $r->data_solicitacao_d . "</td>";
    echo "<td>" . $r->atraso . "</td>";
    echo "<td>" . $r->carater . "</td>";
    echo "</tr>";
}


