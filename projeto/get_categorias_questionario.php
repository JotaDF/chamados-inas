<?php
  
        foreach ($categorias as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->nome."</td>";
            if($usuario_logado->perfil < 2){
                echo "  <td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\",".$questionario->id.")'><i class='far fa-trash-alt'></i></button></td>";
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }
