<?php
require_once('./actions/ManterNotificacao.php');
require_once('./dto/Notificacao.php');
	
$db_notificacao = new ManterNotificacao();
$n = new Notificacao();

$lida = isset($_REQUEST['lida']) ? $_REQUEST['lida'] : 0;

$lista = $db_notificacao->listarPorUsuario($usuario_logado->id,$lida);
if(count($lista) > 0){
    foreach ($lista as $obj) {

        $icon = "<i title='Interação' class='fas fa-exclamation-triangle text-warning'></i>";
        if ($obj->tipo == "interacao") {
            $icon = " <i title='Mensagem' class='fa fa-envelope text-warning'></i> ";
        }

        $check = "<input type='checkbox' value='".$obj->id."' name='notificacao[]' class='cb-element'>";
        if ($obj->lida == 1) {
            $check = "<i class='fa fa-check-square text-success' aria-hidden='true'></i>";
        }

        echo "<tr>";
        echo "  <td>".$obj->id."</td>";
        echo "  <td>".$obj->texto."</td>";
        echo "  <td align='center'>".$icon."</td>";        
        echo "  <td>".date('d/m/Y h:m', strtotime($obj->data)) ."</td>";
        echo "  <td align='center'><a class='btn btn-sm' href='ler_notificacao.php?id=". $obj->id . "'><i class='fa fa-binoculars' aria-hidden='true'></i></a></td>";
        echo "  <td align='center'><input type='checkbox' value='".$obj->id."' name='notificacao[]' class='cb-element'></td>";
        echo "</tr>";

    }
}

