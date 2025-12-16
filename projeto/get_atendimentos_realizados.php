<?php 
require_once('actions/ManterAtendimentoPericia.php');
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$atendimento_pericia = $manterAtendimentoPericia->listaAtendimentosRealizados();

foreach($atendimento_pericia as $obj) {
    $data_agendada_formatada = date('d/m/Y', strtotime($obj->data_agendada));
    $descricao = explode(";", $obj->descricao);
    echo "<tr>";
    echo "<td>" . $obj->nome.  "</td>";
    echo "<td>" . $obj->telefone. "</td>";
    echo "<td>" . $data_agendada_formatada . "</td>";
    echo "<td>" . $obj->hora_agendada . "</td>";
    echo "<td>" . implode("<br>", $descricao)  . "</td>";
    echo "<td>" . $obj->resultado . "</td>";
    echo "</tr>";
}