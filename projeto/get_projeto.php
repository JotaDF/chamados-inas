<?php
$projeto            = $manterProjeto->listar();
foreach ($projeto as $obj) {

    $hidden_tap     = "<input type='hidden' id='".$obj->id."_tap' value='" . $obj->tap."'>";
    $btn_alterar    = $hidden_tap . "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $obj->nome' onclick='alterar(".$obj->id .",\"".$obj->nome."\",\"".$obj->descricao."\",\"".$obj->orcamento."\",\"".$obj->status."\",\"". $obj->objetivo."\")'><i class='fa fa-edit'></i></button>";
    $btn_excluir    = $obj->excluir ? "<button type='button' class='btn btn-danger btn-sm' onclick='excluir(".$obj->id.",\"".$obj->nome."\")'><i class='far fa-trash-alt'></i></button>" : "<button type='button' class='btn btn-secondary btn-sm' title='possui dependências!'><i class='far fa-trash-alt'></i></button>";
    $btn_acessos    = "<a href='gerenciar_projeto_usuario.php?id=$obj->id' title='Gerenciar Usuários do Projeto'class='btn btn-info btn-sm'><i class='fas fa-users text-white'></i></a>";
    $btn_reportes   = "<a href='reporte.php?id=$obj->id' title='Gerenciar Reportes do Projeto' class='btn btn-dark btn-sm'><i class='fa fa-list text-white'></i></a>";
    $btn_arquivos   = "<a href='arquivo_projeto.php?id=$obj->id' title='Gerenciar Arquivos do Projeto' class='btn btn-success btn-sm'><i class='fa fa-folder-open'></i></a>";
    $btn_eap_item   = "<a href='eap_item.php?id=$obj->id' title='Gerenciar EAP ITEM' class='btn btn-warning btn-sm'><i class='fa fa-retweet'></i></a>";
    
    echo "<tr>";
    echo "<td>" . $obj->id . "</td>";
    echo "<td>". $obj->nome ."</td>";
    echo "<td>" . $obj->descricao . "</td>";
    echo "<td>" . $obj->status . "</td>";
    echo "<td>" . $btn_alterar .  "&nbsp;" . $btn_excluir . "&nbsp;" . $btn_arquivos  ."&nbsp;" .  $btn_acessos . "&nbsp;" . $btn_reportes . "&nbsp;" . $btn_eap_item ."</td>";
    echo "</tr>";
    
}