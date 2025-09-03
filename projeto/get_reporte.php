<?php 

$reportes  = $manterReporte->getReportePorIdProjeto($id_projeto);

foreach ($reportes as $obj) {

    $data         =  date('d/m/Y H:i', strtotime($obj->data));
    $btn_alterar  = "<button class='btn btn-primary btn-sm' onclick='alterar(" . $obj->id . ", \"" . $obj->conteudo . "\", \"" . $obj->indicador . "\", \"" . $obj->tipo . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir  = "<button class='btn btn-danger btn-sm' onclick='excluir(" . $obj->id . ", \"" . $obj->conteudo . "\", \"" . $obj->projeto . "\")'><i class='far fa-trash-alt'></i></button>";
   
    echo $obj->indicador;
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->conteudo . "</td>";
    echo "<td>" . $obj->tipo . "</td>";
    echo "<td>" . $data . "</td>";
    echo "<td>" . $btn_alterar . "&nbsp;" .$btn_excluir . "</td>";
    echo "</tr>";
} 
