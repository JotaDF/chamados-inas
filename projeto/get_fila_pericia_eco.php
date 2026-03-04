<?php
require_once('actions/ManterFilaPericiaEco.php');
$manterFilaPericiaEco = new ManterFilaPericiaEco();
$fila_pericia_eco = $manterFilaPericiaEco->listaFilaPericiaAtendimentoNaoConcluido();
$hoje = date('Y-m-d');
foreach ($fila_pericia_eco as $obj) {

    $agendamento = $manterFilaPericiaEco->verificaAtendimentoExiste($obj->id);
    $data_agendada = (new DateTime($agendamento['data_agendada']))->format('Y-m-d');
    $btn_agendar = "<a href='agendamento_pericia.php?id_fila=" . $obj->id . "&data=$hoje' class='btn btn-warning btn-sm'><i class='fa fa-stethoscope'></i></a>";
    $btn_agendamento_marcado = "<a href='agendamentos.php?id_fila=" . $obj->id . "&data=" . $data_agendada . "&hora=" . $agendamento['hora_agendada']. "&agendado=1' class='btn btn-success btn-sm' title='Está agendado'><i class='fa fa-calendar'></i></a>";

    $data_solicitacao = explode(" ", $obj->data_solicitacao);
    $data_solicitacao_formatada = date('d/m/Y', strtotime($data_solicitacao[0]));
    $descricao = explode(";", $obj->descricao);
    $telefone = explode(";", $obj->telefone);
    $class = "btn btn-info btn-sm";
    $span = "<span style='display:none'></span>";

    $tem_agendamento = $agendamento['agendado'] == true ? $btn_agendamento_marcado : $btn_agendar;
    $onclick = "modalPendencia("
        . json_encode($obj->id) . ","
        . json_encode($obj->pendencia)
        . ")";

    $icon = "<i class='fa fa-exclamation-circle'></i>";

    if ($obj->pendencia !== null && $obj->pendencia != "") {
        $class = "btn btn-danger btn-sm";
        $icon = "<i class='fa fa-exclamation-circle'></i>";
        $span = "<span style='display:none'>PENDENCIA</span>";
    }

    $btn_pendencia = "<button class='" . $class . "' onclick='" . $onclick . "'>$icon$span</button>";


    echo "<tr>";
    echo "<td>" . $obj->autorizacao . "</td>";
    echo "<td>" . $data_solicitacao_formatada . "</td>";
    echo "<td>" . $obj->situacao . "</td>";
    echo "<td>" . implode("<br>", $descricao) . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . implode("<br>", $telefone) . "</td>";
    echo "<td align='center'>" . $tem_agendamento . " " . $btn_pendencia . "</td>";
    echo "</tr>";
}