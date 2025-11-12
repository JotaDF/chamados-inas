<?php
require_once('actions/ManterMedicoPerito.php');
$manterMedicoPerito = new ManterMedicoPerito();
$medico_perico = $manterMedicoPerito->listar();



foreach ($medico_perico as $obj) {

    $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' onclick='alterar(\"" . $obj->id . "\",\"" . $obj->nome . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir = $obj->excluir ? "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $obj->nome' onclick='excluir(\"" . $obj->id . "\",\"" . $obj->nome . "\")'><i class='far fa-trash-alt'></i></button>" : "<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>";

    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . $btn_atualizar . "&nbsp;&nbsp;" . $btn_excluir . "</td>";
    echo "</tr>";
}