<?php
	include_once('actions/ManterOficio.php');   
        
	$manterOficio = new ManterOficio();

	$lista = $manterOficio->listar();
        
        foreach ($lista as $obj) {
            
            echo "<tr>";
            echo "  <td>".$obj->processo."</td>";
            echo "  <td>".$obj->link_sei."</td>";
            echo "  <td>".$obj->assunto ."</td>";  
            echo "  <td>".$obj->origem."</td>";          
            echo "  <td>".$obj->destino."</td>";
            echo "  <td>".$obj->enviado."</td>";
            echo "  <td>".$obj->setor ."</td>";

            $opcoes = "  <td align='center'> - </td>";
            $icon_editar = "<i class='fas fa-eye'></i>";
            $hidden_assunto = "<input type='hidden' id='".$obj->id."_assunto' value='".htmlspecialchars($obj->assunto, ENT_QUOTES)."'>";
            
            $btn_alterar = $hidden_assunto . "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(\"".$obj->id."\",\"" .$obj->processo."\",\"".$obj->link_sei."\",\"".$obj->numero."\",\"".addslashes($obj->assunto)."\",\"".$obj->destino."\",\"".$obj->origem."\",\"".$obj->enviado."\",\"".$obj->atendido."\",\"".$obj->setor."\",\"".$obj->usuario."\", 0)'>". $icon_editar."</button>";
            $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap">'.$btn_alterar.'</button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button></td>';
            
            $btn_arquivo= '&nbsp;&nbsp;<a href="gerenciar_arquivo_oficio.php?id='.$obj->id.'" title="Gerenciar arquivo ofício" class="btn btn-success btn-sm" type="button"><i class="fa fa-file-image"></i></a>';

            if($editar && $origem == $obj->setor){
                $icon_editar =  "<i class='fas fa-edit'></i>";
                $btn_alterar = $hidden_assunto . "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(\"".$obj->id."\",\"" .$obj->processo."\",\"".$obj->link_sei."\",\"".$obj->numero."\",\"".addslashes($obj->assunto)."\",\"".$obj->destino."\",\"".$obj->origem."\",\"".$obj->enviado."\",\"".$obj->atendido."\",\"".$obj->setor."\",\"".$obj->usuario."\", 1)'>". $icon_editar."</button>";
                if($obj->excluir){
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap">'.$btn_alterar.' &nbsp;&nbsp;<button class="btn btn-danger btn-sm" type="button" onclick="excluir('.$obj->id.',\''.$obj->numero.'\')"><i class="far fa-trash-alt"></i></button>'.$btn_arquivo.'</td>';
                } else {
                    $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap">'.$btn_alterar.'</button>&nbsp;&nbsp;<button class="btn btn-secondary btn-sm" type="button"><i class="far fa-trash-alt"></i></button>'.$btn_arquivo.'</td>';
                }
            } else {
                $opcoes = '  <td align="center" valign="bottom" class="align-middle nowrap">'.$btn_alterar . $btn_arquivo.'</td>';
            }
            echo $opcoes;
            echo "</tr>";
        }

