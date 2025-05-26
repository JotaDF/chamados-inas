<?php
  
        foreach ($categorias as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->nome."</td>";
            $btn_alterar = "&nbsp;<button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(".$obj->id.",\"".$obj->nome."\",".$questionario->id.")'><i class='fas fa-edit'></i></button>";
            $btn_excluir = "&nbsp;<button class='btn btn-danger btn-sm' type='button' title='Excluir' onclick='excluir(".$obj->id.",\"".$obj->nome."\",".$questionario->id.")'><i class='far fa-trash-alt'></i></button>";
            $btn_perguntas = "&nbsp;<a class='btn btn-info btn-sm' type='button' title='Gerenciar Perguntas' href='quest_gerenciar_perguntas_categoria.php?id=".$obj->id."&id_questionario=".$questionario->id."'><i class='fa fa-question'></i></a>";
            if($usuario_logado->perfil < 2){
                echo "  <td align='center'>".$btn_alterar . $btn_excluir."</td>";
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }
