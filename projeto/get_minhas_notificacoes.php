<?php
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
	
$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

$lida = isset($_REQUEST['lida']) ? $_REQUEST['lida'] : 0;

$lista = $db_notificacao->listarPorUsuario($usuario_logado->id,$lida);
if(count($lista) > 0){
    foreach ($lista as $obj) {

        $icon = " fas fa-exclamation-triangle ";
        if ($obj->tipo == "interacao") {
            $icon = " fa fa-envelope ";
        }

        $check = "<input type='checkbox' value='".$obj->id."' name='notificacao[]' class='cb-element'>";
        if ($obj->lida == 1) {
            $check = "<i class='fa fa-check-square-o text-success' aria-hidden='true'></i>";
        }

        echo "<tr>";
        echo "  <td>".$obj->id."<sup>o</sup></td>";
        echo "  <td>".$obj->texto."</td>";
        echo "  <td><i class='".$icon." text-white'></i></td>";        
        echo "  <td>".date('d/m/Y h:m', strtotime($obj->data)) ."</td>";
        echo "  <td><a class='dropdown-item d-flex align-items-center' href='ler_notificacao.php?id=". $obj->id . "'><i class='fa fa-binoculars' aria-hidden='true'></i></a></td>";
        echo "  <td><input type='checkbox' value='".$obj->id."' name='notificacao[]' class='cb-element'></td>";
        echo "</tr>";

    }
}

