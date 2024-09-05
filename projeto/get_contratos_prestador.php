<?php
  
        foreach ($prestador->contratos as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->numero."</td>";
            echo "  <td>".$obj->ano."</td>";
            echo "  <td>".($obj->vigente > 0 ? 'Sim':'Não')."</td>";
            if($usuario_logado->perfil <= 2 || $obj->editor == 1){
                $btn_arquivos = '&nbsp;&nbsp;<a href="gerenciar_arquivos_contrato.php?id='.$obj->id.'" title="Gerenciar arquivos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-file-pdf"></i></a>';
                if($obj->excluir){
                    echo "  <td align='center'><button title='Excluir' class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\",".$prestador->id.")'><i class='far fa-trash-alt'></i></button>".$btn_arquivos."</td>";
                } else {
                    echo "  <td align='center'><button title='Possui registros' class='btn btn-secondary btn-sm' type='button'><i class='far fa-trash-alt'></i></button></td>";
                }
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

 