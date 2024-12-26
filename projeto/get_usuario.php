<?php
	include_once('actions/ManterUsuario.php'); 
	include_once('actions/ManterPerfil.php');  
    include_once('actions/ManterSetor.php'); 
        
	$manterUsuario = new ManterUsuario();
	$manterPerfil = new ManterPerfil();
    $manterSetor = new ManterSetor();
        
	$lista = $manterUsuario->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>"; 
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->matricula."</td>";
            echo "  <td>".$obj->nome ."</td>";
            echo "  <td>".$manterSetor->getSetorPorId($obj->setor)->sigla."</td>";
            $txt_ativo = "<a href='mudar_ativo_usuario.php?id=".$obj->id."&ativo=1' ><img src='./img/nao_visivel.svg' width='30'/></a>";
            if($obj->ativo == 1){
                $txt_ativo = "<a href='mudar_ativo_usuario.php?id=".$obj->id."&ativo=0' ><img src='./img/visivel.svg' width='30'/></a>";
            }
            echo "  <td>".$txt_ativo."</td>";

            $btn_agenda = '&nbsp;&nbsp;<a href="save_usuario_agenda.php?id='.$obj->id.'&agenda=1" title="Habilitar agenda!" class="btn btn-info btn-sm" type="button"><i class="fa fa-calendar-plus"></i></a>';
            if($obj->agenda > 0){
                $btn_agenda = '&nbsp;&nbsp;<a href="save_usuario_agenda.php?id='.$obj->id.'&agenda=0" title="Desabilitar agenda!" class="btn btn-info btn-sm" type="button"><i class="fa fa-calendar-times"></i></a>';
            }

            if($usuario_logado->perfil <= 2 || $usuario_logado->id == $obj->id){
                
                if($obj->excluir){
                    echo '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->login.'\',\''.addslashes($obj->nome).'\',\''.$obj->matricula.'\',\''.$obj->cargo.'\',\''.$obj->email.'\',\''.$obj->nascimento.'\',\''.$obj->whatsapp.'\',\''.$obj->linkedin.'\',\''.$obj->ativo.'\',\''.$obj->setor.'\',\''.$obj->perfil.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.$obj->nome.'\')"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_acessos.php?id='.$obj->id.'" title="Gerenciar acessos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-unlock"></i></a>'.$btn_agenda.'</td>';
                } else {
                    echo '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->login.'\',\''.addslashes($obj->nome).'\',\''.$obj->matricula.'\',\''.$obj->cargo.'\',\''.$obj->email.'\',\''.$obj->nascimento.'\',\''.$obj->whatsapp.'\',\''.$obj->linkedin.'\',\''.$obj->ativo.'\',\''.$obj->setor.'\',\''.$obj->perfil.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_acessos.php?id='.$obj->id.'"  title="Gerenciar acessos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-unlock"></i></a>'.$btn_agenda.'</td>';
                }
            }  else {
                echo "  <td align='center'> - </td>";
            }

            echo "</tr>";
        }

