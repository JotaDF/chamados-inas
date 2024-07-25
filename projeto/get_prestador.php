<?php
	include_once('actions/ManterPrestador.php');   
    include_once('actions/ManterTipoPrestador.php'); 
        
	$manterPrestador = new ManterPrestador();
    $manterTipoPrestador = new ManterTipoPrestador();
        
	$lista = $manterPrestador->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->cnpj."</td>";
            echo "  <td>".$obj->nome_fantasia ."</td>";
            echo "  <td>".$manterTipoPrestador->getTipoPrestadorPorId($obj->tipo_prestador)->tipo."</td>";
            echo "  <td>".($obj->ativo > 0 ? 'Sim':'Não')."</td>";

            $btn_agenda = '&nbsp;&nbsp;<a href="save_prestador_agenda.php?id='.$obj->id.'&agenda=1" title="Habilitar agenda!" class="btn btn-info btn-sm" type="button"><i class="fa fa-calendar-plus"></i></a>';
            if($obj->agenda > 0){
                $btn_agenda = '&nbsp;&nbsp;<a href="save_prestador_agenda.php?id='.$obj->id.'&agenda=0" title="Desabilitar agenda!" class="btn btn-info btn-sm" type="button"><i class="fa fa-calendar-times"></i></a>';
            }

            //if($prestador_logado->perfil <= 2 || $prestador_logado->id == $obj->id){
                
                //if($obj->excluir){
                //    echo '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->login.'\',\''.addslashes($obj->nome).'\',\''.$obj->matricula.'\',\''.$obj->cargo.'\',\''.$obj->email.'\',\''.$obj->nascimento.'\',\''.$obj->whatsapp.'\',\''.$obj->linkedin.'\',\''.$obj->ativo.'\',\''.$obj->setor.'\',\''.$obj->perfil.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.$obj->nome.'\')"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_acessos.php?id='.$obj->id.'" title="Gerenciar acessos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-unlock"></i></a>'.$btn_agenda.'</td>';
                //} else {
                //    echo '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->login.'\',\''.addslashes($obj->nome).'\',\''.$obj->matricula.'\',\''.$obj->cargo.'\',\''.$obj->email.'\',\''.$obj->nascimento.'\',\''.$obj->whatsapp.'\',\''.$obj->linkedin.'\',\''.$obj->ativo.'\',\''.$obj->setor.'\',\''.$obj->perfil.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_acessos.php?id='.$obj->id.'"  title="Gerenciar acessos" class="btn btn-warning btn-sm" type="button"><i class="fa fa-unlock"></i></a>'.$btn_agenda.'</td>';
                //}
            //}  else {
                echo "  <td align='center'> - </td>";
            //}

            echo "</tr>";
        }

