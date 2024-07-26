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

            $opcoes = "  <td align='center'> - </td>";
            if($usuario_logado->perfil <= 2){
                if($obj->excluir){
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->cnpj.'\',\''.addslashes($obj->razao_social).'\',\''.addslashes($obj->nome_fantasia).'\',\''.$obj->credenciado.'\',\''.$obj->telefone.'\',\''.$obj->ativo.'\',\''.$obj->tipo_prestador.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.addslashes($obj->razao_social).'\')"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_executor_prestador.php?id='.$obj->id.'" title="Gerenciar executores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-users"></i></a></td>';
                } else {
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->cnpj.'\',\''.addslashes($obj->razao_social).'\',\''.addslashes($obj->nome_fantasia).'\',\''.$obj->credenciado.'\',\''.$obj->telefone.'\',\''.$obj->ativo.'\',\''.$obj->tipo_prestador.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button></td>';
                }
            }
            echo $opcoes;
            echo "</tr>";
        }

