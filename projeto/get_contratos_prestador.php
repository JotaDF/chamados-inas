<?php
  
        foreach ($prestador->contratos as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->numero."</td>";
            echo "  <td>".$obj->valor."</td>";
            echo "  <td>".$obj->ano."</td>";
            echo "  <td>".($obj->vigente > 0 ? 'Sim':'Não')."</td>";
            if($usuario_logado->perfil <= 2 || $obj->editor == 1){
                $btn_arquivos = '&nbsp;&nbsp;<a href="gerenciar_arquivos_contrato.php?numero='.$obj->numero.'&ano='.$obj->ano.'&id='.$prestador->id.'" title="Gerenciar arquivos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-file-pdf"></i></a>';
                $btn_editar = '&nbsp;&nbsp;<button title="Editar" class="btn btn-primary btn-sm" type="button" onclick="alterar('.$obj->id.',\''.$obj->numero.'\',\''.$obj->valor.'\','.$obj->ano.','.$obj->vigente.','.$prestador->id.')"><i class="fa fa-edit"></i></button>';
                if($obj->excluir){
                    echo "  <td align='center'><button title='Excluir' class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->numero."\",\"".$obj->ano."\",".$prestador->id.")'><i class='far fa-trash-alt'></i></button>".$btn_arquivos.$btn_editar."</td>";
                } else {
                    echo "  <td align='center'><button title='Possui registros' class='btn btn-secondary btn-sm' type='button'><i class='far fa-trash-alt'></i></button>".$btn_arquivos.$btn_editar."</td>";
                }
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

 