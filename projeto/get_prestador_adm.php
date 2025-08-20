<?php
	include_once('actions/ManterPrestador.php');   
    include_once('actions/ManterTipoPrestador.php'); 
        
	$manterPrestador = new ManterPrestador();
    $manterTipoPrestador = new ManterTipoPrestador();
    
    $filtro = " WHERE p.id_tipo_prestador = 11 ";
	$lista = $manterPrestador->listar($filtro);
        
        foreach ($lista as $obj) {
            
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->cnpj."</td>";
            echo "  <td>".$obj->razao_social ."</td>";
            echo "  <td>".$manterTipoPrestador->getTipoPrestadorPorId($obj->tipo_prestador)->tipo."</td>";
            echo "  <td>".($obj->ativo > 0 ? 'Sim':'Não')."</td>";

            $btns_gestao = ' - ';
            if($usuario_logado->perfil <= 2){
                $btns_gestao = '&nbsp;&nbsp;<a href="gerenciar_pagamentos_prestador_adm.php?id='.$obj->id.'" title="Gerenciar pagamentos prestador" class="btn btn-success btn-sm" type="button">Pag. <i class="fa fa-plus-square"></i></a>';
            }
            echo "  <td align='center'> " . $btns_gestao . " </td>";
            echo "</tr>";
        }

