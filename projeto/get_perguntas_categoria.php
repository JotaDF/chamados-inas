<?php

foreach ($perguntas as $obj) {
    echo "<tr>";
    echo "  <td>".$obj->id."</td>";
    echo "  <td>".$obj->titulo ." - ". $obj->pergunta."</td>";
    $btn_excluir = "&nbsp;<button class='btn btn-danger btn-sm' type='button' title='Excluir' onclick='excluir(".$obj->id.",\"".$obj->titulo . "- ".$obj->pergunta ."\",".$categoria->id.",".$questionario->id.")'><i class='far fa-trash-alt'></i></button>";
    if($usuario_logado->perfil < 2){
        echo "  <td align='center'>". $btn_excluir."</td>";
    } else {
        echo "  <td align='center'> - </td>";                
    }
    echo "</tr>";
}
