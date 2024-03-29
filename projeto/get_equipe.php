<?php
	include_once('actions/ManterEquipe.php'); 
	
	$manterEquipe = new ManterEquipe();
	
	$lista = $manterEquipe->listar();
    if($usuario_logado->perfil == 2){
        $filtro = ' WHERE criador = ' . $usuario_logado->id;
        $lista = $manterEquipe->listar($filtro);
    }
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->equipe."</td>";
            echo "  <td>".$obj->descricao."</td>";
            if($usuario_logado->perfil<=2 || $usuario_logado->id == $equipe->criador){
                if($obj->excluir){
                    echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->equipe."\",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->equipe."\")'><i class='far fa-trash-alt'></i></button>&nbsp;&nbsp;<a href='gerenciar_equipe.php?id=".$obj->id."' title='Gerenciar equipe' class='btn btn-warning btn-sm' type='button'><i class='fa fa-users'></i></a></td>";
                } else {
                    echo "  <td align='center'><button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->equipe."\",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>&nbsp;&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button>&nbsp;&nbsp;<a href='gerenciar_equipe.php?id=".$obj->id."' title='Gerenciar equipe' class='btn btn-warning btn-sm' type='button'><i class='fa fa-users'></i></a></td>";                
                } 
            } else {
                echo "<td> - </td>";
            }
            echo "</tr>";
        }

