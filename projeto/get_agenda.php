<?php
require_once('./actions/ManterAgenda.php');
$db_agenda = new ManterAgenda();
	
$lista = $db_agenda->getAgendasQueAcesso($usuario_logado->id);

foreach ($lista as $obj) {
    echo '<tr>';
    echo '  <td>'.$obj->usuario.'</td>';
    echo '  <td>'.$obj->nome.'</td>';
    echo '  <td align="center"><a href="agenda.php?id='.$obj->usuario.'" title="Acessar agenda!" class="btn btn-info btn-sm" type="button"><i class="fa fa-calendar-plus"></i></a></td>';
    echo '</tr>';
}

