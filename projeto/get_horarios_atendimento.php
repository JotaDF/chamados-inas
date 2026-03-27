<?php
require_once('actions/ManterConfigAgendaPericia.php');
$manterConfigAgendaPericia = new ManterConfigAgendaPericia();
$horarios = $manterConfigAgendaPericia->listaConfiguracoes();
foreach ($horarios as $obj) {

    $img_visivel = "./img/visivel.svg";
    $img_nao_visivel = "./img/nao_visivel.svg";
    $ativo = $obj->ativo == 1;

    $img = $ativo ? "./img/visivel.svg" : "./img/nao_visivel.svg";
    $title = $ativo ? "Configuração ativa" : "Ativar configuração";

    $btn_info = "<a href='ativa_configuracao_agenda.php?id=$obj->id&status=1'><img src='$img' width='30' title='$title'</button></a>";
    $btn_excluir = "<button type='button' class='btn btn-danger btn-sm' title='Excluir: $obj->nome' onclick='excluir(" . $obj->id . ",\"" . $obj->nome . "\")'><i class='fas fa-trash-alt'></i></button>";
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' 
    onclick='alterar(".$obj->id.",\"" . $obj->nome . "\",\"" . $obj->matutino_inicio . "\",\"" . $obj->matutino_fim . "\",\"" . $obj->matutino_intervalo . "\",
    \"" . $obj->vespertino_inicio . "\",\"" . $obj->vespertino_fim . "\",\"" . $obj->vespertino_intervalo . "\")'><i class='fas fa-edit'></i></button>";


    echo "<tr>";
    echo "<td align='center'>" . $obj->id . "</td>";
    echo "<td align='center'>" . $obj->nome . "</td>";
    echo "<td align='center'>" . $obj->matutino_inicio . "</td>";
    echo "<td align='center'>" . $obj->matutino_fim . "</td>";
    echo "<td align='center'>" . $obj->matutino_intervalo . "</td>";
    echo "<td align='center'>" . $obj->vespertino_inicio . "</td>";
    echo "<td align='center'>" . $obj->vespertino_fim . "</td>";
    echo "<td align='center'>" . $obj->vespertino_intervalo . "</td>";
    echo "<td align='center'>" . $btn_info . "</td>";
    echo "<td align='center'>" . $btn_atualizar . "&nbsp;&nbsp;" . $btn_excluir . "</td>";
    echo "</tr>";
}