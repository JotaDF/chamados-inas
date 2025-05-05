<?php
	include_once('actions/ManterUsuario.php'); 
    include_once('actions/ManterSetor.php'); 
	
	$manterUsuario = new ManterUsuario();
    $manterSetor = new ManterSetor();
	
	$lista = $manterUsuario->listarAniversariantesAll();
    echo '<ul class="list-group" style="width:400px;">';
    foreach ($lista as $obj) {
        $img_day = "";
        $style_day = "";
        $dia = date('d');
        if ($obj->dia == $dia) {
            $img_day   = '<img class="pr-1" src="img/aniversario_dia.svg" width="30" title="Aniversariante do dia!" />';
            $style_day = 'style="background-color: #E6E6FA"'; 
        }
        echo '<li class="list-group-item d-flex justify-content-between align-items-center" '.$style_day.'>'
            . $img_day 
            .'<span style="font-size: 11px;"><a href="perfil_usuario.php?id='.$obj->id.'"><b>'.strtoupper($obj->nome)
            .'</b></a> </span><span class="badge badge-warning badge-pill">'
            .$manterSetor->getSetorPorId($obj->setor)->sigla
            .'</span><span class="badge badge-primary badge-pill">'
            .$obj->dia.'/'.$obj->mes
            .'</span>
        </li>';         
    }
    echo "</ul>";
