<?php
	include_once('actions/ManterEnquete.php'); 
	
	$manterEnquete = new ManterEnquete();
	
	$lista = $manterEnquete->listar();
        
        foreach ($lista as $obj) {
            $hidden_descricao = "<input type='hidden' id='". $obj->id."_descricao'  value='". $obj->descricao ."'>";
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->descricao."</td>";
            $txt_status = "<a href='mudar_status_enquete.php?id=".$obj->id."&status=1' ><img src='./img/nao_visivel.svg' width='30'/></a>";
            if($obj->status == 1){
                $txt_status = "<a href='mudar_status_enquete.php?id=".$obj->id."&status=0' ><img src='./img/visivel.svg' width='30'/></a>";
            }
            echo "  <td align='center'>".$txt_status."</td>";
            $btn_folder= '&nbsp;&nbsp;<a href="gerenciar_folder_enquete.php?id='.$obj->id.'" title="Gerenciar folder" class="btn btn-success btn-sm" type="button"><i class="fa fa-file-image"></i></a>';            
            $btn_opcoes = '&nbsp;&nbsp;<a href="gerenciar_opcoes_enquete.php?id='.$obj->id.'" title="Gerenciar opções" class="btn btn-warning btn-sm" type="button"><i class="fa fa-list-ul"></i></a>';
            $btn_resultado = '&nbsp;&nbsp;<a href="resultado_enquete.php?id='.$obj->id.'" title="Resultado da enquete" class="btn btn-success btn-sm" type="button"><i class="fa fa-signal"></i></a>';
            if($obj->excluir){
                echo "  <td align='center'>$hidden_descricao<button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->descricao."\")'><i class='far fa-trash-alt'></i></button>" . $btn_opcoes . $btn_folder . $btn_resultado . "</td>";
            } else {
                echo "  <td align='center'>$hidden_descricao<button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>" . $btn_opcoes . $btn_folder . $btn_resultado . "</td>";                
            }
            echo "</tr>";
        }

