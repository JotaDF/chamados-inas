<?php
	include_once('actions/ManterModulo.php'); 
	
	$manterModulo = new ManterModulo();
	
	$lista = $manterModulo->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->nome."</td>";
            echo "  <td>".$obj->descricao."</td>";
            if($obj->excluir){
                echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->nome."\",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\")'><i class='far fa-trash-alt'></i></button></td>";
            } else {
                echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->nome."\",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td>";                
            }
            echo "</tr>";
        }

