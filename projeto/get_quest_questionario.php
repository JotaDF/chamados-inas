<?php
	include_once('actions/ManterQuestQuestionario.php'); 
	
	$manterQuestQuestionario = new ManterQuestQuestionario();
	
	$lista = $manterQuestQuestionario->getQuestionarioPorIdUsuario($usuario_logado->id);
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->titulo."</td>";
            echo "  <td>".$obj->descricao."</td>";
            $btn_alterar = "&nbsp;<button class='btn btn-primary btn-sm' type='button' title='Editar' onclick='alterar(".$obj->id.",\"".$obj->titulo."\",\"".$obj->descricao."\")'><i class='fas fa-edit'></i></button>";
            $btn_aplicacoes = "&nbsp;<a class='btn btn-info btn-sm' type='button' title='Gerenciar Aplicações' href='quest_gerenciar_aplicacoes_questionario.php?id=".$obj->id."'><i class='fa fa-flag'></i></a>";
            $btn_categorias = "&nbsp;<a class='btn btn-warning btn-sm' type='button' title='Gerenciar Categorias' href='quest_gerenciar_categorias_questionario.php?id=".$obj->id."'><i class='fa fa-tags'></i></a>";
            $btn_dashboard = "&nbsp;<a class='btn btn-success btn-sm' type='button' title='Gerenciar Categorias' href='quest_resposta.php?id=".$obj->id."'><i class='fa fa-signal'></i></a>";
            if($obj->excluir){
                echo "  <td align='center'>".$btn_alterar.$btn_aplicacoes.$btn_categorias.$btn_dashboard."&nbsp;<button class='btn btn-danger btn-sm' type='button' title='Excluir' onclick='excluir(".$obj->id.",\"".$obj->titulo."\")'><i class='far fa-trash-alt'></i></button></td>";
            } else {
                echo "  <td align='center'>".$btn_alterar.$btn_aplicacoes.$btn_categorias.$btn_dashboard."&nbsp;<button class='btn btn-secondary btn-sm' type='button' title='Possuí dependências!'><i class='far fa-trash-alt' alt='Possuí dependências!'></i></button></td>";                
            }
            echo "</tr>";
        }

 