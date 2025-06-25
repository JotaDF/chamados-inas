<?php
$objetivo = $manterObjetivo->getObjetivoPorIdPlanejamento($planejamento->id);
foreach ($objetivo as $o) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $o->descricao' onclick='alterar(\"" . $o->id . "\",\"" . $o->descricao . "\",)'><i class='fas fa-edit'></i></button>";
    
    $btn_excluir = $o->excluir ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $o->descricao' onclick='excluir(\"" . $o->id . "\",\"" . $o->descricao . "\",".$id_planejamento.")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";
    $btn_indicador = "<a href='indicador.php?id=$o->id' class='btn btn-success btn-sm' title='Cadastrar Indicador'>IN</a>";
    
    echo "<tr>";
    echo "<td>" . $o->id . "</td>";
    echo "<td>" . $o->descricao . "</td>";
    echo " <td>" . $btn_atualizar .  "&nbsp;" . $btn_indicador . "&nbsp;" . $btn_excluir .  "</td>";
    echo "</tr>";
}
