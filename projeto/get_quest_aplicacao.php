<?php 
$manterQuestAplicacao = new ManterQuestAplicacao();

$lista = $manterQuestAplicacao->getAplicacaoPorId($id_questionario);
foreach ($lista as $obj) {
    echo "<tr>";
    echo "  <td>" . $obj->id . "</td>";
    echo "  <td >" . date('d/m/Y', strtotime($obj->inicio)). "</td>";
    echo "  <td>" . date('d/m/Y', strtotime($obj->termino)) . "</td>";
    $btn_ver_quest = "";
    if($obj->publicado == 1) {
        $txt_publicado = "<a href='mudar_publicado_aplicacao.php?id=" . $obj->id . "&publicado=0&id_questionario=" . $id_questionario . "'><img src='./img/visivel.svg' width='30'/></a>";
        $btn_ver_quest = "&nbsp;<a class='btn btn-warning btn-sm' title='Visualizar Questionário!' href='aplicar_questionario.php?id=" . $id_questionario . "&aplicacao=".$obj->id."' target='_blank'><i class='fa fa-binoculars'></i></a>";
    } else {
        $txt_publicado = "<a href='mudar_publicado_aplicacao.php?id=" . $obj->id . "&publicado=1&id_questionario=" . $id_questionario . "' ><img src='./img/nao_visivel.svg' width='30'/></a>";
    }
    echo "  <td align='center'>" . $txt_publicado . "</td>";
    $btn_alterar = "&nbsp;<button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(".$obj->id.",\"".$obj->inicio."\",\"".$obj->termino."\")'><i class='fas fa-edit'></i></button>";

    if ($obj->excluir) {
        echo "  <td align='center'>" . $btn_ver_quest . "&nbsp;" . $btn_alterar . "&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$id_questionario."\")'><i class='far fa-trash-alt'></i></button></td>";
    } else {
        echo "  <td align='center'>" . $btn_ver_quest . "&nbsp;" . $btn_alterar .  "&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td></td>";
    }
    echo "</tr>";
}
