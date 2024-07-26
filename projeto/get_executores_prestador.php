<?php
  
        foreach ($prestador->executores as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->matricula."</td>";
            echo "  <td>".$obj->nome."</td>";
            echo "  <td>".($obj->editor > 0 ? 'Sim':'Não')."</td>";
            if($usuario_logado->perfil <= 2 ){
                echo "  <td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\",".$prestador->id.")'><i class='far fa-trash-alt'></i></button></td>";
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

