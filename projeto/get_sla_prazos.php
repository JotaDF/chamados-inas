<?php 
$manterSlaPrazo = new ManterSlaPrazo();
$sla_prazo = $manterSlaPrazo->listaSlaPrazo();

    foreach($sla_prazo as $sp) {

        $btn_atualizar = "<button type='button' class='btn btn-primary btn-sm' title='Alterar: $sp->tipo_guia / $sp->fila' onclick='alterar(\"".$sp->id."\", \"" . $sp->tipo_guia . "\", \"" . $sp->fila . "\", \"".$sp->prazo_dias."\")'><i class='fas fa-edit'></i></button>";
        $btn_excluir   = "<button type='button' class='btn btn-danger btn-sm'  title='Excluir: $sp->tipo_guia / $sp->fila' onclick='excluir(\"".$sp->id."\",\"".$sp->tipo_guia."\", \"".$sp->fila."\")'><i class='far fa-trash-alt'></i></button>";
        echo "<tr>";
        echo " <td>" . $sp->tipo_guia ."</td>";
        echo " <td>" . $sp->fila ."</td>";
        echo " <td>" . $sp->prazo_dias ."</td>";
        echo " <td>" . $btn_atualizar .  "&nbsp;&nbsp;&nbsp;" . $btn_excluir . "</td>";
        echo "</tr>";
    }
