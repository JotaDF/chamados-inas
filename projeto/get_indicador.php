<?php 
$indicadores = $manterIndicador->getIndicadorPorObjetivo($id_objetivo);

foreach($indicadores as $obj) {
    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' onclick='alterar(\"" . $obj->id . "\",\"" . $obj->nome . "\",\"" . $obj->unidade . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir   = $obj->excluir == true ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $obj->nome' onclick='excluir(\"" . $obj->id . "\",\"" . $obj->nome . "\",".$id_objetivo.")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";
    $btn_metas     = "<a href='meta.php?id=$obj->id' class='btn btn-warning btn-sm' title='Cadastrar Metas: $obj->nome'><i class='bi bi-award'></i></a>";
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . $obj->unidade . "</td>";
    echo "<td>" . $btn_atualizar . "&nbsp;" . $btn_metas . "&nbsp;" .$btn_excluir . "</td>";
    echo "</tr>";
} 
