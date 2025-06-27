<?php
$objetivo = $manterObjetivo->getObjetivoPorIdPlanejamento($planejamento->id);
foreach ($objetivo as $o) {
    $hidden_descricao    ="<input type='hidden' id='".$o->id."_descricao' value='" . $o->descricao."'>";
    $btn_alterar         = $hidden_descricao ."<button type='button' class='btn btn-primary btn-sm' title='Alterar' onclick='alterar(\"" . $o->id . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir        = $o->excluir ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $o->descricao' onclick='excluir(\"" . $o->id . "\",".$id_planejamento.")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";
    $btn_indicador      = "<a href='indicador.php?id=$o->id&pl=$id_planejamento' class='btn btn-warning btn-sm' title='Cadastrar Indicador'><i class='bi bi-bar-chart-line'></i></a>";
    $btn_porjeto        = "<a href='projeto.php?id=$o->id' class='btn btn-class btn-info'>P</a>";
    echo "<tr>";
    echo "<td>" . $o->id . "</td>";
    echo "<td>" . $o->descricao . "</td>";
    echo " <td>" . $btn_alterar .  "&nbsp;" . $btn_indicador . "&nbsp;" . $btn_excluir .  "</td>";
    echo "</tr>";
}
