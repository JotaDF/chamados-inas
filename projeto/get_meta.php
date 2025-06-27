<?php
$metas = $manterMeta->getMetaPorIndicador($id_indicador);
foreach ($metas as $obj) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->valor' onclick='alterar(\"" . $obj->id . "\",\"" . $obj->valor . "\",\"" . $obj->data_inicio . "\",\"" . $obj->data_fim . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir = $obj->excluir ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $obj->valor' onclick='excluir(\"" . $obj->id . "\",\"" . $obj->valor . "\"," . $id_indicador . ")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";

    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->valor . "</td>";
    echo "<td>" . date('d/m/Y H:i', strtotime($obj->data_inicio)) . "</td>";
    echo "<td>" . date('d/m/Y H:i' , strtotime($obj->data_fim)) . "</td>";
    echo " <td>" . $btn_atualizar . "&nbsp;" . $btn_excluir . "</td>";
    echo "</tr>";
}