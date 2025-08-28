<?php 

$usuarios = $manterProjeto->getProjetoUsuarioPorId($id_projeto);

foreach ($usuarios as $obj) {

    $btn_excluir = "<button class='btn btn-danger btn-sm' type='button' onclick='excluir(" . $obj->id_usuario . ",\"" . $obj->id_perfil_projeto . "\", \"" . $obj->nome . "\")'><i class='far fa-trash-alt'></i></button>";
    $btn_alterar = "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(". $obj->id_perfil_projeto ."," . $obj->id_usuario .")'><i class='fas fa-edit'></i></button>";

    echo "<tr>";
    echo "<td>" . $obj->id_perfil_projeto . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td>" . $obj->perfil . "</td>";
    echo "<td align='center'>" .  /*. $btn_excluir . "&nbsp". */ $btn_excluir . "</td>";
    echo "</tr>";
}