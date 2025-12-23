<?php
require_once('actions/ManterAtendimentoPericia.php');
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$atendimento_pericia = $manterAtendimentoPericia->listaAtendimentosRealizados();

foreach ($atendimento_pericia as $obj) {
    $data_agendada_formatada = date('d/m/Y', strtotime($obj->data_agendada));
    $descricao = explode(";", $obj->descricao);
    $telefone = explode(";", $obj->telefone);
    $btn_info = "<button class='btn btn-primary btn-sm' onclick='getDadosAtendimentoRealizado(\"{$obj->id}\")'><i class='fa fa-info-circle'></i></button>";
    echo "<tr>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . implode("<br>", $telefone) . "</td>";
    echo "<td align='center'>" . $data_agendada_formatada . "</td>";
    echo "<td align='center'>" . $obj->hora_agendada . "</td>";
    echo "<td>" . implode("<br>", $descricao) . "</td>";
    echo "<td>" . $obj->resultado . "</td>";
    echo "<td align='center'>" . $btn_info . "</td>";
    echo "</tr>";
}