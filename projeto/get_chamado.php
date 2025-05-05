<?php

date_default_timezone_set('America/Sao_Paulo');

include_once('actions/ManterChamado.php');
include_once('actions/ManterUsuario.php');
include_once('actions/ManterCategoria.php');
include_once('actions/ManterSetor.php');

$manterChamado = new ManterChamado();
$manterUsuario = new ManterUsuario();
$manterCategoria = new ManterCategoria();
$manterSetor = new ManterSetor();

$lista = $manterChamado->listar($filtro);

foreach ($lista as $obj) {
    $txt_setor = $manterSetor->getSetorPorId($manterUsuario->getUsuarioPorId($obj->usuario)->setor)->sigla;
    $txt_usuario = $manterUsuario->getUsuarioPorId($obj->usuario)->nome;
    $txt_categoria = $manterCategoria->getCategoriaPorId($obj->categoria)->nome;
    /****************** Status legend *****************
     * 0 - Aberto
     * 1 - Em atendimento
     * 2 - Concluído
     * 3 - Cancelado
     * 4 - Reaberto
     *************************************************/

    $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
    switch ($obj->status) {
        case 0:
            $txt_status = '<img src="img/chamado_aberto.svg" title="Novo" width="40" />';
            break;
        case 1:
            $txt_status = '<img src="img/chamado_atendimento.svg" title="Em atendimento" width="40" />';
            break;
        case 2:
            $txt_status = '<img src="img/chamado_concluido.svg" title="Concluído" width="40" />';
            break;
        case 3:
            $txt_status = '<img src="img/chamado_cancelado.svg" title="Cancelado" width="40" />';
            break;
        case 4:
            $txt_status = '<img src="img/chamado_reaberto.svg" title="Reaberto" width="40" />';
            break;
    }
    $array_setor = explode ("/",$txt_setor);
    //echo "TOTAL: " . count($array_setor);
    echo "<tr>";
    echo "  <td>".$obj->id."</td>";
    echo "  <td>" . $array_setor[count($array_setor)-1] . "</td>";
    echo "  <td>" . $txt_usuario . "</td>";
    echo "  <td>" . $txt_categoria . "</td>";
    echo "  <td>" . date('d/m/Y H:i', strtotime($obj->data_abertura)) . "</td>";
    echo "  <td align='center'>" . $txt_status . "</td>";

    $link_atender = "";
    $link_cancelar = "";
    $link_reabrir = "";
    if ($usuario_logado->perfil == 1 || $usuario_logado->perfil == 2 || $usuario_logado->perfil == 9) {
        $link_atender = "<button class='btn btn-primary btn-sm' type='button' onclick='atender(".$obj->id.",\"". $txt_usuario ."\",\"".$obj->descricao."\",".$obj->categoria.")' title='Atender chamado'><i class='fa fa-clock'></i></button>&nbsp;&nbsp;";
        $link_cancelar = "<button class='btn btn-danger btn-sm' type='button' onclick='cancelar(".$obj->id.",\"". $txt_usuario ."\",\"".$obj->descricao."\",".$usuario_logado->id.")'  title='Cancelar chamado'><i class='fa fa-ban'></i></button>";
        $link_reabrir = "<button class='btn btn-warning btn-sm' type='button' onclick='reabrir(".$obj->id.",\"". $txt_usuario ."\",\"".$obj->descricao."\",".$obj->categoria.",".$usuario_logado->id.")' title='Reabrir chamado'><i class='fa fa-history'></i></button>";
    }
    if($usuario_logado->id == $obj->usuario){
        $link_cancelar = "<button class='btn btn-danger btn-sm' type='button' onclick='cancelar(".$obj->id.",\"". $txt_usuario ."\",\"".$obj->descricao."\",".$usuario_logado->id.")'  title='Cancelar chamado'><i class='fa fa-ban'></i></button>";
        $link_reabrir = "<button class='btn btn-warning btn-sm' type='button' onclick='reabrir(".$obj->id.",\"". $txt_usuario ."\",\"".$obj->descricao."\",".$obj->categoria.",".$usuario_logado->id.")' title='Reabrir chamado'><i class='fa fa-history'></i></button>";
    }

    if($obj->status == 0){
        echo "  <td align='center'>".$link_atender." " . $link_cancelar;
    } else if($obj->status == 1){
        echo "  <td align='center'><a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes.php?id=".$obj->id."' title='Interações chamado'><i class='fa fa-bars'></i></a>&nbsp;&nbsp;" . $link_cancelar . "</td>";
    } else if($obj->status == 2){
        echo "  <td align='center'><a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes.php?id=".$obj->id."' title='Interações chamado'><i class='fa fa-bars'></i></a>&nbsp;&nbsp;" . $link_reabrir . "</td>";
    } else if($obj->status == 4){
        echo "  <td align='center'>".$link_atender."" . $link_cancelar . "</td>";
    } else {
        echo "  <td align='center'> <a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes.php?id=".$obj->id."' title='Interações chamado'><i class='fa fa-bars'></i></a></td>";
    }
    echo "</tr>";
}

