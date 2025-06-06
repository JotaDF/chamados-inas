<?php
	include_once('actions/ManterLicitacao.php'); 
	
	$manterLicitacao = new ManterLicitacao();
	
	$lista = $manterLicitacao->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->modalidade."</td>";
            echo "  <td>".$obj->certame."</td>";
            $btn_arquivos = '&nbsp;&nbsp;<a href="gerenciar_arquivos_licitacao.php?id='.$obj->id.'&modalidade='.$obj->modalidade.'&certame='.$obj->certame.'&ano='.$obj->ano.'" title="Gerenciar arquivos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-file-pdf"></i></a>';
            if($obj->excluir){
                echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->modalidade."\",\"".$obj->certame."\",\"".$obj->ano."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->modalidade."\",\"".$obj->certame."\")'><i class='far fa-trash-alt'></i></button>".$btn_arquivos."</td>";
            } else {
                echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->modalidade."\",\"".$obj->certame."\",\"".$obj->ano."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>".$btn_arquivos."</td>";                
            }
            echo "</tr>";
        }

