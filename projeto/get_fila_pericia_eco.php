<?php
require_once('actions/ManterFilaPericiaEco.php');
$manterFilaPericiaEco = new ManterFilaPericiaEco();
$fila_pericia_eco = $manterFilaPericiaEco->listaFilaPericiaAtendimentoNaoConcluido();
$hoje = date('Y-m-d');
foreach ($fila_pericia_eco as $obj) {

    $btn_atender = "<a href='agendamento_pericia.php?id_fila=" . $obj->id . "&data=$hoje' class='btn btn-warning btn-sm'><i class='fa fa-stethoscope'></i></a>";
    
    $data_solicitacao = explode(" ", $obj->data_solicitacao);
    $data_solicitacao_formatada = date('d/m/Y', strtotime($data_solicitacao[0]));
    $descricao = explode(";", $obj->descricao);
    $telefone = explode(";", $obj->telefone);
    
    
    
    echo "<tr>";
    echo "<td>" . $obj->autorizacao . "</td>";
    echo "<td>" . $data_solicitacao_formatada . "</td>";
    echo "<td>" . $obj->situacao . "</td>";
    echo "<td>" .implode("<br>", $descricao)  .  "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . implode("<br>", $telefone) . "</td>";
    echo "<td align='center'>" . $btn_atender . "</td>";
    echo "</tr>";
}