<?php
  
        foreach ($ocorrencias as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->descricao."</td>";
            echo "  <td>".($obj->resolvido > 0 ? 'Sim':'Não')."</td>";
            echo "  <td>".date('d/m/Y h:i', strtotime($obj->data))."</td>";
            $btn_resolver = "";
            $txt_status = "<a title='Marcar como resolvida!' href='mudar_status_ocorrencia_nota.php?id_nota=".$obj->id."&id_prestador=".$prestador->id."&tp=".$tp."&status=1' class='btn btn-success btn-sm'><i class='fa fa-check'></i></a>";
            if($obj->ativo == 1){
                $txt_status = "<a title='Marcar como não resolvida!' href='mudar_status_ocorrencia_nota.php?id_nota=".$obj->id."&id_prestador=".$prestador->id."&tp=".$tp."&status=0' class='btn btn-warning btn-sm' ><i class='fa fa-exchange'></i></a>";
            }
            $btn_alterar = "<button title='Excluir' class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",".$usuario_logado->id.",\"".$obj->descricao."\",".$prestador->id.",".$id_nota.")'><i class='fas fa-edit'></i></button>";
            if($usuario_logado->perfil <= 2){
                if($usuario_logado->perfil <= 2){
                    $btn_resolver =  "&nbsp;&nbsp;" . $txt_status;
                }
                if($obj->resolvido == 0){
                    echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;<button title='Excluir' class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",".$usuario_logado->id.",\"".$obj->descricao."\",".$prestador->id.",".$id_nota.")'><i class='far fa-trash-alt'></i></button>".$btn_resolver."</td>";
                } else {
                    echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;<button title='Ocorrência já resolvida' class='btn btn-secondary btn-sm' type='button'><i class='far fa-trash-alt'></i></button>".$btn_ativar."</td>";
                }
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

 