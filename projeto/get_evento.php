<?php
	include_once('actions/ManterEvento.php'); 
	
	$manterEvento = new ManterEvento();
	
	$lista = $manterEvento->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->titulo."</td>";
            $txt_inscreve = $obj->inscreve == 1 ? "SIM" : "NÃO";
            echo "  <td>". $txt_inscreve ."</td>";
            echo "  <td align='center'><a href='relatorio_inscritos_evento.php?id=".$obj->id."' target='_blank'>".$manterEvento->getTotalInscritos($obj->id)."</a></td>";
            $txt_status = "<a href='mudar_status_evento.php?id=".$obj->id."&status=1' ><img src='./img/nao_visivel.svg' width='30'/></a>";
            if($obj->status == 1){
                $txt_status = "<a href='mudar_status_evento.php?id=".$obj->id."&status=0' ><img src='./img/visivel.svg' width='30'/></a>";
            }
            echo "  <td align='center'>".$txt_status."</td>";
            $btn_folder= '&nbsp;&nbsp;<a href="gerenciar_folder_evento.php?id='.$obj->id.'" title="Gerenciar folder" class="btn btn-success btn-sm" type="button"><i class="fa fa-file-image"></i></a>';
            $btn_inscricoes = '&nbsp;&nbsp;<a href="gerenciar_inscricoes_evento.php?id='.$obj->id.'" title=":Lista de inscritos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-list-ul"></i></a>';
            $btn_alterar = "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->titulo."\",\"".$obj->descricao."\",\"".$obj->inscreve."\",\"".$obj->data."\",\"".$obj->hora."\")'><i class='fas fa-edit'></i></button>";
            if($obj->excluir){
                echo "  <td align='center'>" . $btn_alterar . "&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->descricao."\")'><i class='far fa-trash-alt'></i></button>" . $btn_inscricoes . $btn_folder .  "</td>";
            } else {
                echo "  <td align='center'>" . $btn_alterar . "&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>" . $btn_inscricoes . $btn_folder ."</td>";                
            }
            echo "</tr>";
        }

