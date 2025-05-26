<?php
include_once('actions/manterQuestQuestionario.php');

$manterQuestQuestionario = new manterQuestQuestionario();
$lista = $manterQuestQuestionario->listar();

foreach ($lista as $obj) {
    echo "<tr>";
    echo "  <td>" . $obj->id . "</td>";
    echo "  <td>" . $obj->titulo . "</td>";
    $btn_alterar = "&nbsp;<button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(" . $obj->id . ",\"" . $obj->titulo . "\",\"" . $obj->descricao . "\")'><i class='fas fa-edit'></i></button>";
    $txt_status = "<a href='mudar_status_enquete.php?id=" . $obj->id . "&status=1' ><img src='./img/nao_visivel.svg' width='30'/></a>";
    if ($obj->status == 1) {
        $txt_status = "<a href='mudar_status_enquete.php?id=" . $obj->id . "&status=0' ><img src='./img/visivel.svg' width='30'/></a>";
    }
    //$btn_aplicacoes = "&nbsp;<a class='btn btn-info btn-sm' type='button' title='Gerenciar Aplicações' href='quest_gerenciar_aplicacoes_questionario.php?id=".$obj->id."'><i class='fa fa-flag'></i></a>";
    // $btn_categorias = "&nbsp;<a class='btn btn-warning btn-sm' type='button' title='Gerenciar Categorias' href='quest_gerenciar_categorias_questionario.php?id=".$obj->id."'><i class='fa fa-tags'></i></a>";
    if ($obj->excluir) {
        echo "  <td align='center'>" . $btn_alterar . $btn_aplicacoes . $btn_categorias . "&nbsp;<button class='btn btn-danger btn-sm' type='button' title='Excluir' onclick='excluir(" . $obj->id . ",\"" . $obj->titulo . "\")'><i class='far fa-trash-alt'></i></button></td>";
    } else {
        echo "  <td align='center'>" . $btn_alterar . $btn_aplicacoes . $btn_categorias . "&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td>";
    }
    echo "</tr>";
}
