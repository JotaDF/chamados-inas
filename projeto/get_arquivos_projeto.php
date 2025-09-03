<?php 

$arquivos = $manterArquivo->getArquivosPorIdProjeto($id_projeto);
foreach ($arquivos as $obj) {

    $btn_excluir = "<button class='btn btn-danger btn-sm' onclick='excluir(" . $obj->id . ", \"" . $obj->nome . "\", \"" . $obj->url . "\", \"" . $id_projeto . "\" )'><i class='far fa-trash-alt'></i></button>";
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->nome . "</td>";
    echo "<td><a href='" . $obj->url . "'>" . $obj->url . "</a></td>";
    echo "<td>" . $obj->tipo . "</td>";
    echo "<td>" . $btn_excluir . "</td>";
    echo "</tr>";
}