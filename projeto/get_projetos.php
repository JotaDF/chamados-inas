<?php

$projeto            = $manterProjeto->listar();

foreach ($projeto as $obj) {
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" . $obj->descricao . "</td>";
    echo "<td>" . $obj->tap . "</td>";
    echo "<td>" . $obj->orcamento . "</td>";
    echo "<td>" . $obj->status . "</td>";
    echo "</tr>";
}