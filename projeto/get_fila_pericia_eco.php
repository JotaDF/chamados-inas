<?php 
require_once('actions/ManterFilaPericiaEco.php');
$manterFilaPericiaEco = new ManterFilaPericiaEco();
$fila_pericia_eco = $manterFilaPericiaEco->listaFilaPericiaSemAtendimento();

foreach($fila_pericia_eco as $obj) {

    $btn_atender = "<a href='agendamento_pericia.php?id=".$obj->id."' class='btn btn-warning btn-sm'><i class='fa fa-stethoscope'></i></a>";
    $data_solicitacao = explode(" ", $obj->data_solicitacao);
    $data_solicitacao_formatada = date('d/m/Y', strtotime($data_solicitacao[0]));
    echo "<tr>";
    echo "<td>" . $obj->autorizacao. "</td>";
    echo "<td>" . $data_solicitacao_formatada. "</td>";
    echo "<td>" . $obj->situacao. "</td>";
    echo "<td>" . $obj->descricao . "</td>";
    echo "<td>" . $obj->nome.  "</td>";
    echo "<td>" . $obj->telefone.  "</td>";
    echo "<td align='center'>". $btn_atender ."</td>";
    echo "</tr>";
}