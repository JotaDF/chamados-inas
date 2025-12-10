<?php
	include_once('actions/ManterAcessoOficio.php'); 
	
	$db_acesso_oficio = new ManterAcessoOficio();
	
	$lista = $db_acesso_oficio->getUsuariosComAcessoOficio($origem);
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->matricula."</td>";
            echo "  <td>".$obj->nome."</td>";
            echo "  <td>".$obj->setor."</td>";
            echo "  <td>".($obj->editor==1 ? "SIM" : "NÃO")."</td>";
            echo "  <td>".($obj->ativo==1 ? "ATIVO" : "INATIVO")."</td>";
            if($obj->excluir){
                echo "  <td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->nome."\")'><i class='far fa-trash-alt'></i></button></td>";
            } else {
                echo "  <td align='center'> - </td>";                
            }
            echo "</tr>";
        }

