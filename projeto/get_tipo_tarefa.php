<?php 
require_once('./actions/ManterTipoTarefa.php');
$manterTipoTarefa = new ManterTipoTarefa();

$lista = $manterTipoTarefa->listar();

foreach ($lista as $obj) {
    $btn_salvar = "<button class='btn btn-primary btn-sm' type=''button' onclick='alterar(".$obj->id.",\"". $obj->nome ."\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir = "&nbsp&nbsp<button class='btn btn-danger btn-sm' type=''button' onclick='excluir(".$obj->id.",\"". $obj->nome ."\")'><i class='far fa-trash-alt'></i></button>";
    echo "<tr>";
    echo "<td>". $obj->id . "</td>";
    echo "<td>". $obj->nome . "</td>";
    echo "<td>". $btn_salvar . $btn_excluir ."</td>";
    echo "</tr>";
}