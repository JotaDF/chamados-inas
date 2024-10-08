<?php
	include_once('actions/ManterPrestador.php');   
    include_once('actions/ManterTipoPrestador.php'); 
        
	$manterPrestador = new ManterPrestador();
    $manterTipoPrestador = new ManterTipoPrestador();
        
	$lista = $manterPrestador->listarPorExecutor($usuario_logado->id);
        
        foreach ($lista as $obj) {
            $exibir = false;
            if($tp == 0){
                $exibir = true;
            } else if($tp == 1 && $obj->editor == 1){
                $exibir = true;
            } else if($tp == 2 && $obj->editor == 0){
                $exibir = true;
            }
            if ($exibir) {            
                echo "<tr>";
                echo "  <td>".$obj->id."</td>";
                echo "  <td>".$obj->cnpj."</td>";
                echo "  <td>".$obj->razao_social ."</td>";
                echo "  <td>".$manterTipoPrestador->getTipoPrestadorPorId($obj->tipo_prestador)->tipo."</td>";
                echo "  <td>".($obj->ativo > 0 ? 'Sim':'Não')."</td>";

                $opcoes = "  <td align='center'> - </td>";
                if($usuario_logado->perfil >= 2){
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap"><a href="gerenciar_pagamentos_prestador.php?id='.$obj->id.'" title="Gerenciar pagamentos prestador" class="btn btn-success btn-sm" type="button">Pag. <i class="fa fa-plus-square"></i></a>&nbsp;&nbsp;<a href="gerenciar_glosas_prestador.php?id='.$obj->id.'" title="Gerenciar pagamentos de recursos de glosas" class="btn btn-danger btn-sm" type="button">Glos. <i class="fa fa-plus-square"></i></a></td>';
                }
                echo $opcoes;
                echo "</tr>";
            }
        }

