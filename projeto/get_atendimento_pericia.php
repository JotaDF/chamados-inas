<?php 
require_once('actions/ManterAtendimentoPericia.php');
$manterAtendimentoPericia = new ManterAtendimentoPericia();
$atendimento_pericia = $manterAtendimentoPericia->listar();


foreach($atendimento_pericia as $obj) {
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>" ..  "</td>";
    echo "<td>" .. "</td>";
    echo "<td>" .. "</td>";
    echo "</tr>";
}