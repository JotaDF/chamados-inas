<?php
	include_once('actions/ManterPrestador.php');   
    include_once('actions/ManterTipoPrestador.php'); 
        
	$manterPrestador = new ManterPrestador();
    $manterTipoPrestador = new ManterTipoPrestador();

    $filtro = " WHERE p.id_tipo_prestador <> 12 ";
	$lista = $manterPrestador->listar($filtro);
        
        foreach ($lista as $obj) {
            
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->cnpj."</td>";
            echo "  <td>".$obj->razao_social ."</td>";
            echo "  <td>".$manterTipoPrestador->getTipoPrestadorPorId($obj->tipo_prestador)->tipo."</td>";
            echo "  <td>".($obj->ativo > 0 ? 'Sim':'Não')."</td>";

            $opcoes = "  <td align='center'> - </td>";
            $btns_gestao = '';
            if($usuario_logado->perfil <= 2){
                $btns_gestao = '&nbsp;&nbsp;<a href="gerenciar_pagamentos_prestador.php?id='.$obj->id.'" title="Gerenciar pagamentos prestador" class="btn btn-success btn-sm" type="button">Pag. <i class="fa fa-plus-square"></i></a>&nbsp;&nbsp;<a href="gerenciar_glosas_prestador.php?id='.$obj->id.'" title="Gerenciar pagamentos de recursos de glosas" class="btn btn-danger btn-sm" type="button">Glos. <i class="fa fa-plus-square"></i></a>';
            }
            if($usuario_logado->perfil >= 2 && $usuario_logado->perfil != 12 && $usuario_logado->perfil != 4){ 
                if($obj->excluir){
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->cnpj.'\',\''.addslashes($obj->razao_social).'\',\''.addslashes($obj->nome_fantasia).'\',\''.$obj->credenciado.'\',\''.$obj->telefone.'\',\''.$obj->ativo.'\',\''.$obj->processo_sei.'\',\''.$obj->tipo_prestador.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.addslashes($obj->razao_social).'\')"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_executor_prestador.php?id='.$obj->id.'" title="Gerenciar executores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-users"></i></a>'.$btns_gestao.'</td>';
                } else {
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><button class="btn btn-primary btn-sm" type="button" onclick="alterar(\''.$obj->id.'\',\'' .$obj->cnpj.'\',\''.addslashes($obj->razao_social).'\',\''.addslashes($obj->nome_fantasia).'\',\''.$obj->credenciado.'\',\''.$obj->telefone.'\',\''.$obj->ativo.'\',\''.$obj->processo_sei.'\',\''.$obj->tipo_prestador.'\')"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button>&nbsp;&nbsp;<a href="gerenciar_executor_prestador.php?id='.$obj->id.'" title="Gerenciar executores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-users"></i></a>'.$btns_gestao.'</td>';
                }
            }
            echo $opcoes;
            echo "</tr>";
        }

