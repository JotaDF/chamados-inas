<?php 


foreach ($perfil as $p) {
    $btn_atualizar = "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(" . $p->id . ",\"" . $p->nome . "\")'><i class='fas fa-edit'></i></button>";
    $btn_excluir   = "<button class='btn btn-danger btn-sm' type='button' onclick='excluir(" . $p->id . ",\"" . $p->nome . "\")'><i class='far fa-trash-alt'></i></button>";
    echo "<tr>";
    echo "  <td>" . $p->id . "</td>";
    echo "  <td>" . $p->nome . "</td>";
    if($p->excluir) {
    echo "<td>" . $btn_atualizar .  "&nbsp;&nbsp;" . $btn_excluir .  "</td>";
    } else {
    echo "<td>" . $btn_atualizar . "&nbsp;&nbsp<button class='btn btn-secondary btn-sm' type='button' title='Possui dependências'><i class='far fa-trash-alt'></i></button></td>";
    }
    echo "</td>";
    echo "</tr>";
}