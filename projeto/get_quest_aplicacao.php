<?php 
$manterQuestAplicacao = new ManterQuestAplicacao();

$lista = $manterQuestAplicacao->getAplicacaoPorId($id_questionario);
foreach ($lista as $obj) {
    echo "<tr>";
    echo "  <td>" . $obj->id . "</td>";
    echo "  <td >" . date('d/m/Y', strtotime($obj->inicio)). "</td>";
    echo "  <td>" . date('d/m/Y', strtotime($obj->termino)) . "</td>";
    if($obj->publicado == 1) {
        $txt_publicado = "<a href='mudar_publicado_aplicacao.php?id=" . $obj->id . "&publicado=0&id_questionario=" . $id_questionario . "'><img src='./img/visivel.svg' width='30'/></a>";
    } else {
        $txt_publicado = "<a href='mudar_publicado_aplicacao.php?id=" . $obj->id . "&publicado=1&id_questionario=" . $id_questionario . "' ><img src='./img/nao_visivel.svg' width='30'/></a>";
    }
    $btn_alterar = "&nbsp;<button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(".$obj->id.",\"".$obj->inicio."\",\"".$obj->termino."\")'><i class='fas fa-edit'></i></button>";
    echo "  <td align='center'>" . $txt_publicado . "</td>";
    if ($obj->excluir) {
        echo "  <td align='center'>" . $btn_alterar . "&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.")'><i class='far fa-trash-alt'></i></button></td>";
    } else {
        echo "  <td align='center'>" . $btn_alterar .  "&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td></td>";
    }
    echo "</tr>";
}
