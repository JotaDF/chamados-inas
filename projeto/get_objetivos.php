<?php
$objetivo = $manterObjetivo->getObjetivoPorIdPlanejamento($planejamento->id);
foreach ($objetivo as $o) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $o->descricao' onclick='alterar(\"" . $o->id . "\",\"" . $o->descricao . "\",)'><i class='fas fa-edit'></i></button>";
    $btn_excluir = "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $o->descricao' onclick='excluir(\"" . $o->id . "\",\"" . $o->descricao . "\",)'><i class='far fa-trash-alt'></i></button>";
    echo "<tr>";
    echo "<td>" . $o->id . "</td>";
    echo "<td>" . $o->descricao . "</td>";
    echo " <td>" . $btn_atualizar .  "&nbsp;" .  $btn_excluir . "</td>";
    echo "</tr>";
}
