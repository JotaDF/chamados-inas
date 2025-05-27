<?php
require_once 'actions/ManterQuestPergunta.php';
$manterQuestPergunta = new ManterQuestPergunta();

$quest_pergunta_lista = $manterQuestPergunta->listar();

foreach ($quest_pergunta_lista as $obj) {
    echo "<tr>";
    echo "  <td>" . $obj->id . "</td>";
    echo "  <td>" . $obj->titulo . "</td>";
    echo "  <td>" . $obj->pergunta . "</td>";
    if ($obj->opcional == 1) {
        echo "  <td> Sim </td>";
    } else {
        echo "  <td> Não </td>";
    }
    echo "  <td>" . $obj->escala . "</td>";
    if ($obj->excluir) {
        echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(" . $obj->id . ",\"" . $obj->titulo . "\",\"" . $obj->pergunta . "\",\"" . $obj->nome . "\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' title='Excluir' onclick='excluir(" . $obj->id . ",\"" . $obj->titulo . "\")'><i class='far fa-trash-alt'></i></button></td>";
    } else {
        echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(" . $obj->id . ",\"" . $obj->titulo . "\",\"" . $obj->pergunta . "\",\"" . $obj->id_quest_escala . "\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td>";
    };
    echo "</tr>";
}