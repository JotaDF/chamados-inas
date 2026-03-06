<?php
require_once('actions/ManterFilaPericiaEco.php');
date_default_timezone_set('America/Sao_Paulo');

$manterFilaPericiaEco = new ManterFilaPericiaEco();

$feriados = $manterFilaPericiaEco->geraListaFeriados();
$fila_pericia_eco = $manterFilaPericiaEco->listaFilaPericiaAtendimentoNaoConcluido();
$amanha = $manterFilaPericiaEco->getProximoDiaUtil();

foreach ($fila_pericia_eco as $obj) {

    $agendamento = $manterFilaPericiaEco->verificaAtendimentoExiste($obj->id);
    $data_agendada = (new DateTime($agendamento['data_agendada']))->format('Y-m-d');

    // Botões de agendamento
    $btn_agendar = "<a href='agendamento_pericia.php?id_fila={$obj->id}&data=$amanha' class='btn btn-warning btn-sm'><i class='fa fa-stethoscope'></i></a>";
    $btn_agendamento_marcado = "<a href='agendamentos.php?id_fila={$obj->id}&data={$data_agendada}&hora={$agendamento['hora_agendada']}&agendado=1' class='btn btn-success btn-sm' title='Está agendado'><i class='fa fa-calendar'></i></a>";

    $tem_agendamento = $agendamento['agendado'] ? $btn_agendamento_marcado : $btn_agendar;

    // Pendência
    $hidden_pendencia = "<input type='hidden' id='{$obj->id}_pendencia' value='{$obj->pendencia}'>";
    $conteudo = trim(strip_tags($obj->pendencia));

    $class = $conteudo !== "" ? "btn btn-danger btn-sm" : "btn btn-info btn-sm";
    $span = $conteudo !== "" ? "<span style='display:none'>PENDENCIA</span>" : "";

    $btn_pendencia = $hidden_pendencia .
        "<button class='$class' onclick='modalPendencia(" . json_encode($obj->id) . ")'>
            <i class='fa fa-exclamation-circle'></i>$span
        </button>";

    // Formatações
    $data_solicitacao_formatada = date('d/m/Y', strtotime(explode(" ", $obj->data_solicitacao)[0]));
    $descricao = implode("<br>", explode(";", $obj->descricao));
    $telefone = implode("<br>", explode(";", $obj->telefone));

    echo "<tr>";
    echo "<td>" . $obj->autorizacao . "</td>";
    echo "<td>" . $data_solicitacao_formatada . "</td>";
    echo "<td>" . $obj->situacao . "</td>";
    echo "<td>" .  $descricao . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" .  $telefone . "</td>";
    echo "<td align='center'>" . $tem_agendamento . " " . $btn_pendencia . "</td>";
    echo "</tr>";

}
