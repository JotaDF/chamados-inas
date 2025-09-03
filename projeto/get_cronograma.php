<?php

$cronogramas = $manterCronograma->getCronogramaPorEapId($id_eap_item);

foreach ($cronogramas as $obj) {

    $descricao_hidden = "<input type='hidden' id='". $obj->id."_descricao' value='". $obj->descricao ."'>";
    $btn_alterar      = $descricao_hidden . "&nbsp;<button class='btn btn-primary btn-sm' title='Alterar: $obj->descricao' onclick='alterar(" . $obj->id . ",\"" . $obj->inicio_prev . "\",\"" . $obj->fim_prev . "\", \"" . $obj->inicio_real . "\", \"" . $obj->fim_real . "\", \"" . $obj->status . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir      = "&nbsp;<button class='btn btn-danger btn-sm' title='Excluir: $obj->descricao' onclick='excluir(" . $obj->id . ",\"" . $obj->descricao . "\"," . $id_eap_item . ")'><i class='far fa-trash-alt'></i></button>";
    
    switch ($obj->status) {
        case "Não Iniciado":
            $status_icon        = '"fa fa-play"';
            $status_title       = '"Não Iniciado"';
            $btn_class_status   = "btn-warning";
            $btn_icon_status    = "fa fa-play";
            $btn_onclick_status = "onclick='iniciar(" . $obj->id . ", " . $id_eap_item . ", \"" . $obj->descricao ."\")'";
            break;
        case "Iniciado":
            $status_icon        = '"fa fa-bullseye"';
            $status_title       = '"Iniciado"';
            $btn_class_status   = "btn-info";
            $btn_icon_status    = "fa fa-bullseye";
            $btn_onclick_status = "onclick='finalizar(" . $obj->id . ", " . $id_eap_item . ", \"" . $obj->descricao ."\")'";
            break;
        case "Finalizado":
            $status_icon        = '"fa fa-check"';
            $status_title       = '"Finalizado"';
            $btn_class_status   = "btn-success";
            $btn_icon_status    = "fa fa-check";
            $btn_onclick_status = "";
            break;
    }
    $btn_title  = $obj->status == 'Finalizado' ? "'Finalizado'": "'Atualizar Status: $obj->descricao'";
    $btn_status = "&nbsp;<button class='btn $btn_class_status btn-sm' $obj->status title=$btn_title  $btn_onclick_status><i class='$btn_icon_status'></i></button>";
    $status     = "<i class=$status_icon title=$status_title text-white></i>";
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>". htmlspecialchars(strip_tags($obj->descricao)) ."</td>";
    echo "<td class='text-center'>" . ($obj->inicio_prev == null ? "-" : date('d/m/Y', strtotime($obj->inicio_prev))) . "</td>";
    echo "<td class='text-center'>" . ($obj->inicio_real == null ? "-" : date('d/m/Y', strtotime($obj->inicio_real))) . "</td>";
    echo "<td class='text-center'>" . ($obj->fim_prev == null ? "-" : date('d/m/Y', strtotime($obj->fim_prev))) . "</td>";
    echo "<td class='text-center'>" . ($obj->fim_real == null ? "-" : date('d/m/Y', strtotime($obj->fim_real))) . "</td>";
    echo "<td class='text-center'> $status</td>";
    echo "<td>" . $btn_alterar .  $btn_excluir .  $btn_status . "</td>";
    echo "</tr>";
}