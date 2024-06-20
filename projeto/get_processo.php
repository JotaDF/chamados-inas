<?php

    date_default_timezone_set('America/Sao_Paulo');  

	include_once('actions/ManterProcesso.php'); 
    include_once('actions/ManterAssunto.php'); 
	
	$manterProcesso = new ManterProcesso();
    $manterAssunto = new ManterAssunto();
	
	$lista = $manterProcesso->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->numero."</td>";
            echo "  <td>".$obj->cpf."</td>";
            echo "  <td>".$obj->beneficiario."</td>";
            echo "  <td>".date('d/m/Y', $obj->autuacao)."</td>";
            echo "  <td>".$manterAssunto->getAssuntoPorId($obj->assunto)->assunto."</td>";
            echo "  <td>".$obj->valor_causa."</td>";
            $btn_valores = '&nbsp;&nbsp;<a href="gerenciar_valores_processo.php?id='.$obj->id.'" title="Gerenciar valores" class="btn btn-warning btn-sm" type="button"><i class="fa fa-credit-card"></i></a>';
            $btn_vinculos = '&nbsp;&nbsp;<a href="gerenciar_processos_vinculados.php?id='.$obj->id.'" title="Gerenciar processos vinculados" class="btn btn-info btn-sm" type="button"><i class="fa fa-link"></i></a>';
            $btn_alterar = "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->numero."\",\"".$obj->sei."\",\"".date('Y-m-d', $obj->autuacao)."\",\"".$obj->cpf."\",\"".$obj->beneficiario."\",\"".$obj->guia."\",\"".$obj->valor_causa."\",\"".$obj->assunto."\",\"".$obj->situacao_processual."\",\"".$obj->liminar."\",\"". date('Y-m-d', $obj->data_cumprimento_liminar)."\",\"".$obj->instancia."\",\"".$obj->processo_principal."\",\"".$obj->classe_judicial."\")'><i class='fas fa-edit'></i></button>";
            if($obj->processo_principal != ""){
                $btn_alterar = "<button class='btn btn-secondary btn-sm' type='button' title='É um processo vinculado'><i class='fas fa-edit'></i></button>";
            }
            if($obj->excluir){
                echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->numero."\",\"".$obj->cpf."\",\"".$obj->beneficiario."\")'><i class='far fa-trash-alt'></i></button>".$btn_valores.$btn_vinculos."</td>";
            } else {
                echo "  <td align='center'>".$btn_alterar."&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>".$btn_valores.$btn_vinculos."</td>";                
            }
            echo "</tr>";
        }

