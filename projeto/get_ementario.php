<?php
	include_once('actions/ManterEmentario.php'); 
	
	$manterEmentario = new ManterEmentario();
	
	$lista = $manterEmentario->listar();
        
        foreach ($lista as $obj) {
            echo "<tr>";
            echo "  <td>".$obj->id."</td>";
            echo "  <td>".$obj->processo_sei."</td>";
            echo "  <td>". $obj->doc_sei ."</td>";
            echo "  <td>".$obj->nota_juridica."</td>";
            echo "  <td>".$obj->ementa."</td>";
            $hidden_ementa = "<input type='hidden' id='".$obj->id."_ementa' value='" . $obj->ementa."'>";
            $btn_alterar = $hidden_ementa . "<button class='btn btn-primary btn-sm' type='button' onclick='alterar(".$obj->id.",\"".$obj->processo_sei."\",\"".$obj->doc_sei."\",\"".$obj->nota_juridica."\")'><i class='fas fa-edit'></i></button>";
            echo "  <td align='center'>" . $btn_alterar . "&nbsp;&nbsp;<button class='btn btn-danger btn-sm' type='button' onclick='excluir(".$obj->id.",\"".$obj->processo_sei."\")'><i class='far fa-trash-alt'></i></button></td>";
            echo "</tr>";
        }

