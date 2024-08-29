<?php
  
        foreach ($prestador->executores as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->matricula."</td>";
            echo "  <td>".$obj->nome."</td>";
            echo "  <td>".($obj->editor > 0 ? 'Sim':'Não')."</td>";
            echo "  <td>".($obj->ativo > 0 ? 'Sim':'Não')."</td>";
            $btn_ativar = "";
            $txt_status = "<a title='Ativar' href='mudar_status_executor.php?id_usuario=".$obj->id."&id_prestador=".$prestador->id."&status=1' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></a>";
            if($obj->ativo == 1){
                $txt_status = "<a title='Desativar' href='mudar_status_executor.php?id_usuario=".$obj->id."&id_prestador=".$prestador->id."&status=0' class='btn btn-warning btn-sm' ><i class='fa fa-eye-slash'></i></a>";
            }
            if($usuario_logado->perfil <= 2 || $obj->editor == 1){
                if($usuario_logado->perfil <= 2){
                    $btn_ativar = "&nbsp;&nbsp;" . $txt_status;
                }
                if($obj->excluir){
                    echo "  <td align='center'><button title='Excluir' class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\",".$prestador->id.")'><i class='far fa-trash-alt'></i></button>".$btn_ativar."</td>";
                } else {
                    echo "  <td align='center'><button title='Possui registros' class='btn btn-secondary btn-sm' type='button'><i class='far fa-trash-alt'></i></button>".$btn_ativar."</td>";
                }
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

 