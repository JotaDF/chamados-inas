<?php
	include_once('actions/ManterOficio.php');   
        
	$manterOficio = new ManterOficio();

	$lista = $manterOficio->listar();
        
        foreach ($lista as $obj) {
            
            echo "<tr>";
            echo "  <td>".$obj->processo."</td>";
            echo "  <td>".$obj->link_sei."</td>";
            echo "  <td>".$obj->assunto ."</td>";            
            echo "  <td>".$obj->destino."</td>";
            echo "  <td>".$obj->enviado."</td>";
            echo "  <td>".$obj->setor ."</td>";

            $opcoes = "  <td align='center'> - </td>";
            $btns_gestao = '';
            if($usuario_logado->perfil >= 2 || $usuario_logado->perfil == 1){ 
                if($obj->excluir){
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->processo.'\',\''.$obj->link_sei.'\',\''.$obj->numero.'\',\''.addslashes($obj->assunto).'\',\''.$obj->destino.'\',\''.$obj->origem.'\',\''.$obj->enviado.'\',\''.$obj->atendido.'\',\''.$obj->setor.'\',\''.$obj->usuario.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.$obj->numero.'\')"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_executor_oficio.php?id='.$obj->id.'" title="Gerenciar executores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-users"></i></a>'.$btns_gestao.'</td>';
                } else {
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->processo.'\',\''.$obj->link_sei.'\',\''.$obj->numero.'\',\''.addslashes($obj->assunto).'\',\''.$obj->destino.'\',\''.$obj->origem.'\',\''.$obj->enviado.'\',\''.$obj->atendido.'\',\''.$obj->setor.'\',\''.$obj->usuario.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_executor_oficio.php?id='.$obj->id.'" title="Gerenciar executores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-users"></i></a>'.$btns_gestao.'</td>';
                }
            }
            echo $opcoes;
            echo "</tr>";
        }

