<?php

date_default_timezone_set('America/Sao_Paulo');

include_once('actions/ManterSolicitacao.php');
include_once('actions/ManterUsuario.php');
include_once('actions/ManterCategoria.php');
include_once('actions/ManterSetor.php');
include_once('actions/ManterInteracao.php');

$manterSolicitacao = new ManterSolicitacao();
$manterUsuario = new ManterUsuario();
$manterSetor = new ManterSetor();
$manterInteracao = new ManterInteracao();



$lista = $manterSolicitacao->getSolicitacoesPorIdUsuario($usuario_logado->id);

foreach ($lista as $obj) {

    /****************** Status legend *****************
     * 0 - Aberto
     * 1 - Em atendimento
     * 2 - Concluído
     * 3 - Cancelado
     * 4 - Reaberto
     *************************************************/

    $icone_atendimento = "";

    $status = $obj->status;

    $link_cancelar = "<button class='btn btn-danger btn-sm' type='button' onclick='cancelar(" . $obj->id . ",\"" . $txt_usuario . "\",\"" . htmlspecialchars($obj->descricao, ENT_QUOTES) . "\"," . $usuario_logado->id . ")'  title='Cancelar solicitação'><i class='fa fa-ban'></i></button>";

    $btn_interacoes = "<a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes_solicitacao.php?id=" . $obj->id . "' title='Interações solicitação'><i class='fa fa-bars'></i></a>";

    //$btn_atender = "<button class='btn btn-primary btn-sm' type='button' onclick='atender(" . $obj->id . ",\"" . $txt_usuario . "\",\"" . htmlspecialchars($obj->descricao, ENT_QUOTES) . "\"," . $usuario_logado->id . ")'  title='Atender solicitação'><i class='fa fa-clock text-white'></i></button>";

    //$link_atender = $obj->solicitante != $usuario_logado->id ? $btn_atender : "";

    switch ($status) {

        case 0: // Aberto
            $icone_atendimento = "<i class='fa fa-inbox fa-2x text-primary' title='Nova Solicitação'></i>";
            $link_interacoes = "";
            break;

        case 1: // Em atendimento
            $icone_atendimento = "<i class='fa fa-hourglass-start fa-2x text-warning' title='Solicitação em Atendimento'></i>";
            $link_interacoes = $btn_interacoes;
            break;

        case 2: // Concluído
            $icone_atendimento = "<i class='fa fa-check-circle fa-2x text-success' title='Solicitação Concluída'></i>";
            $link_interacoes = $btn_interacoes;
            $link_cancelar = "";
            break;

        case 3: // Cancelado
            $icone_atendimento = "<i class='fa fa-ban fa-2x text-danger' title='Solicitação Cancelada'></i>";
            $link_interacoes = $btn_interacoes;
            $link_cancelar = "";
            break;
    }

    //$link_atender = "<a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes_solicitacao.php?id=" . $obj->id . "&arquivo=$possuiArquivo' title='Interações chamado'><i class='fa fa-bars'></i></a>";
    // $btn_atender = "<button class='btn btn-primary btn-sm' type='button' onclick='atender(" . $obj->id . ",\"" . $txt_usuario . "\",\"" . htmlspecialchars($obj->descricao, ENT_QUOTES) . "\",\"" . $obj->status . "\",\"" . htmlspecialchars($motivo_reabertura, ENT_QUOTES) . "\"," . $obj->categoria . ")' title='Atender chamado'><i class='fa fa-clock'></i></button>&nbsp;&nbsp;";

    $pasta = './anexos_solicitacao/' . $obj->id . "_solicitacao";

    $link_arquivo = "#";
    $onclick = "";
    $titulo = "";
    $icone_arquivo = "";
    $totalArquivos = 0;
    $arquivos = [];

    if (is_dir($pasta)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($pasta, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $arquivo) {
            if ($arquivo->isFile()) {
                $arquivos[] = $arquivo->getPathname();
            }
        }

        $totalArquivos = count($arquivos);

        if ($totalArquivos === 1) {
            $link_arquivo = $arquivos[0];
            $titulo = 'Baixar anexo';
            $icone_arquivo = "fa fa-file fa-2x text-info";
        } elseif ($totalArquivos > 1) {
            $onclick = "onclick=\"mostraAnexos($obj->id, '$pasta'); return false;\"";
            $titulo = 'Visualizar anexos';
            $icone_arquivo = "fa fa-folder-open fa-2x text-info";
        }
    }

    $possui_arquivo = $obj->anexos
        ? "<a href='$link_arquivo' target='_blank' title='$titulo' class='d-inline-block' $onclick><i class='$icone_arquivo'></i></a>"
        : "---";


    $solicitante = $manterSolicitacao->getSolicitantePorIdUsuario($obj->solicitante);


    // $link_interacoes = $obj->status == "Em Atendimento" ? $btn_interacoes : $link_atender;

    echo "<tr>";
    echo "  <td>" . $obj->id . "</td>";
    echo "  <td>" . $obj->chave . "</td>";
    echo "  <td>" . $obj->setor . "</td>";
    echo "  <td>" . $solicitante . "</td>";
    echo "  <td>" . $obj->descricao . "</td>";
    if ($setor !== 'dijur') {
        echo "  <td>" . $obj->responsavel . "</td>";
    }
    echo "  <td>" . date('d/m/Y H:i', strtotime($obj->data_abertura)) . "</td>";
    echo "  <td align='center'>" . $possui_arquivo . "</td>";
    echo "  <td align='center'>" . $icone_atendimento . "</td>";
    echo "  <td align='center'>" . $link_interacoes . " " . $link_atender . " " . $link_cancelar;

    //$link_atender = "<a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes_solicitacao.php?id=" . $obj->id . "&arquivo=$possuiArquivo' title='Interações chamado'><i class='fa fa-bars'></i></a>";
    $link_cancelar = "";
    $link_reabrir = "";
    $link_arquivos_vinculados = "<a class='btn btn-warning btn-sm' type='button' href='gerenciar_arquivos_solicitacoes_dijur.php?id=" . $obj->id . " title='Arquivos'><i class='fa fa-file'></i></a>";
    $motivo_reabertura = $obj->status == 4 ? $manterInteracao->getMotivoReabertura($obj->id) : "";

    // if ($obj->solicitante != $usuario_logado->id) {
    //     echo "  <td align='center'>" . $link_atender . " " . $link_cancelar;
    // } else {
    //     echo "<td align='center'>" . $link_cancelar;
    // }

    echo "</tr>";
}



