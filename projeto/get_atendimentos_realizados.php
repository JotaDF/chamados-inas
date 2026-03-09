<?php
require_once('actions/ManterAtendimentoPericia.php');
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$atendimento_pericia = $manterAtendimentoPericia->listaAtendimentosRealizados();

foreach ($atendimento_pericia as $obj) {

    $data_agendada_formatada = date('d/m/Y', strtotime($obj->data_agendada));
    $descricao = explode(";", $obj->descricao);

    if (strlen($obj->descricao) > 50) {
        $descricao = [mb_substr($obj->descricao, 0, 50, 'UTF-8') . "..."];
    }

    $telefone = explode(";", $obj->telefone);

    $btn_info = "<button class='btn btn-primary btn-sm'  title='Vizualizar informações do atendimento' onclick='getDadosAtendimentoRealizado($obj->id)'><i class='fa fa-info-circle'></i></button>";
    $span_descricao = "<span style='display:none' class='export-full' >$obj->descricao</span>";

    echo "<tr>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . implode("<br>", $telefone) . "</td>";
    echo "<td align='center'>" . $data_agendada_formatada . "</td>";
    echo "<td align='center'>" . $obj->hora_agendada . "</td>";
    echo "<td data-export='" . htmlspecialchars($obj->descricao, ENT_QUOTES, 'UTF-8') . "'>". implode("<br>", $descricao). $span_descricao ."</td>";
    echo "<td>" . $obj->resultado . "</td>";
    echo "<td align='center'>" . $btn_info . "</td>";
    echo "</tr>";
}