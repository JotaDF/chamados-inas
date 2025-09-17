<?php 
require_once('actions/ManterFeriadoAno.php');
$manterFeriadoAno = new ManterFeriadoAno();
$feriados = $manterFeriadoAno->lista();


foreach($feriados as $obj) {
    $btn_opcoes  = "<button class='btn btn-primary btn-sm' title='Alterar $obj->descricao' onclick='alterar(" . $obj->id . ",\"".$obj->data."\",\"".$obj->descricao."\" )'><i class='fas fa-edit'></i></button>";
    $btn_excluir = "&nbsp;&nbsp;<button class='btn btn-danger btn-sm' title='Excluir: $obj->descricao' onclick='excluir(" . $obj->id . ",\"".$obj->descricao."\")'><i class='far fa-trash-alt'></i></button>";
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td class='text-center'>" .date('d/m/Y', strtotime($obj->data)). "</td>";
    echo "<td>" . $obj->descricao . "</td>";
    echo "<td>" . $btn_opcoes . $btn_excluir . "</td>";
    echo "</tr>";
}