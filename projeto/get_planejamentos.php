<?php 


foreach ($planejamento as $p) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $p->nome / $p->ano_inicio' onclick='alterar(\"".$p->id."\",\"" . $p->nome . "\",\"" . $p->ano_inicio . "\", \"".$p->ano_fim."\",\"".$p->missao."\",\"".$p->visao."\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir   = $p->excluir ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $p->nome / $p->ano_inicio' onclick='excluir(\"".$p->id."\",\"".$p->nome."\",\"".$p->missao."\")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";
    $btn_objetivo  = "<a href='objetivo.php?id=$p->id' class='btn btn-info btn-sm' title='Cadastrar Objetivos: $p->nome'><i class='fa fa-bullseye text-white'></i></a>";
    
    echo "<tr>";
    echo "<td>" . $p->id . "</td>";
    echo "<td>" . $p->nome . "</td>";
    echo "<td>" . $p->ano_inicio . "</td>";
    echo "<td>" . $p->ano_fim . "</td>";
    echo " <td>" . $btn_atualizar .  "&nbsp;" . $btn_objetivo  . "&nbsp;"  .  $btn_excluir . "</td>";
    echo "</tr>";
}