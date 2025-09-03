<?php


foreach ($eap_item as $obj) {

    $eap_item_nome = $obj->id_eap_item ? $manterEapItem->getEapItemPaiPorId($obj->id_eap_item)->nome : "-";
   
    $eap_item_pai  = $obj->id_eap_item == null ? "-" : $obj->id_eap_item;
    $btn_alterar   = "<button class='btn btn-primary btn-sm' onclick='alterar(" . $obj->id . ", \"" . $obj->nome . "\", \"" . $obj->id_eap_item . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir   = $obj->excluir == true ? "<button class='btn btn-danger btn-sm'  onclick='excluir(" . $obj->id . ", \"" . $obj->nome . "\",". $id_projeto .")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' title='Possui Dependencias'><i class='far fa-trash-alt'></i></button>";
    $btn_conograma = "<a href='cronograma.php?id=$obj->id&p=$id_projeto'class='btn btn-info btn-sm' title='Gerenciar Conograma' ><i class='fa fa-clock'></i></a>";
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . $eap_item_nome . "</td>";
    echo "<td>" . $btn_alterar . "&nbsp;" . $btn_excluir . "&nbsp;" .  $btn_conograma . "</td>";
    echo "</tr>";
}