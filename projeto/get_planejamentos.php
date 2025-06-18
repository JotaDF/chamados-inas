<?php 


foreach ($planejamento as $p) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $p->nome / $p->ano_inicio' onclick='alterar(\"".$p->id."\",\"" . $p->nome . "\",\"" . $p->ano_inicio . "\", \"".$p->ano_fim."\",\"".$p->missao."\",\"".$p->visao."\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir   = "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $p->nome / $p->ano_inicio' onclick='excluir(\"".$p->id."\",\"".$p->nome."\",\"".$p->missao."\")'><i class='far fa-trash-alt'></i></button>";
    $btn_objetivo  = "<a href='objetivo.php?id=$p->id' class='btn btn-info btn-sm' title='Cadastrar Objetivos: $p->nome'><i class='fa fa-bullseye text-white'></i></a>";
    $missao_planejamento = strlen($p->missao) > 100 ? substr($p->missao, 0, 30) . '...' : $p->missao;
    $visao_planejamento = strlen($p->visao) > 100 ? substr($p->visao, 0, 30) . '...' : $p->visao;
    echo "<tr>";
    echo "<td>" . $p->id . "</td>";
    echo "<td>" . $p->nome . "</td>";
    echo "<td>" . $p->ano_inicio . "</td>";
    echo "<td>" . $p->ano_fim . "</td>";
    echo "<td>" . $missao_planejamento . "</td>";
    echo "<td>" . $visao_planejamento. "</td>";
    echo " <td>" . $btn_atualizar .  "&nbsp;" . $btn_objetivo  . "&nbsp;"  .  $btn_excluir . "</td>";
    echo "</tr>";
}