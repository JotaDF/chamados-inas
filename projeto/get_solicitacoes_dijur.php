<?php

date_default_timezone_set('America/Sao_Paulo');

include_once('actions/ManterSolicitacao.php');
include_once('actions/ManterUsuario.php');
include_once('actions/ManterCategoria.php');
include_once('actions/ManterSetor.php');
include_once('actions/ManterInteracaoSolicitacao.php');

$manterSolicitacao = new ManterSolicitacao();
$manterUsuario = new ManterUsuario();
$manterSetor = new ManterSetor();
$manterInteracaoSolicitacao = new ManterInteracaoSolicitacao();



$lista = $manterSolicitacao->listar($filtro);


/****************** Status legend *****************
 * 0 - Aberto
 * 1 - Em atendimento
 * 2 - Concluído
 * 3 - Cancelado
 * 4 - Reaberto
 *************************************************/

foreach ($lista as $solicitacao) {

    $status = $solicitacao->status;
    $txt_usuario = $manterUsuario->getUsuarioPorId($solicitacao->solicitante)->nome;

    // Botões padrão
    $link_cancelar = "<button class='btn btn-danger btn-sm' type='button' onclick='cancelar(" . $solicitacao->id . ",\"" . $txt_usuario . "\",\"" . htmlspecialchars($solicitacao->descricao, ENT_QUOTES) . "\"," . $usuario_logado->id . ")' title='Cancelar solicitação'><i class='fa fa-ban'></i></button>";

    $btn_interacoes = "<a class='btn btn-primary btn-sm' type='button' href='gerenciar_interacoes_solicitacao.php?id=" . $solicitacao->id . "' title='Interações chamado'><i class='fa fa-bars'></i></a>";

    $btn_atender = "<button class='btn btn-primary btn-sm' type='button' onclick='atender(" . $solicitacao->id . ",\"" . $txt_usuario . "\",\"" . htmlspecialchars($solicitacao->descricao, ENT_QUOTES) . "\"," . $usuario_logado->id . ")' title='Atender solicitação'><i class='fa fa-clock text-white'></i></button>";

    // Valores padrão
    $icone_atendimento = "";
    $link_interacoes = "";
    $link_atender = $solicitacao->solicitante != $usuario_logado->id ? $btn_atender : "";

    switch ($status) {

        case 0: // Aberto
            $icone_atendimento = "<i class='fa fa-inbox fa-2x text-primary' title='Nova Solicitação'></i>";
            $link_interacoes = "";
            $link_atender = $solicitacao->solicitante != $usuario_logado->id
                ? $btn_atender
                : "";
            break;

        case 1: // Em atendimento
            $icone_atendimento = "<i class='fa fa-hourglass-start fa-2x text-warning' title='Solicitação em Atendimento'></i>";
            $link_interacoes = $btn_interacoes;
            $link_atender = "";
            break;

        case 2: // Concluído
            $icone_atendimento = "<i class='fa fa-check-circle fa-2x text-success' title='Solicitação Concluída'></i>";
            $link_interacoes = $btn_interacoes;
            $link_cancelar = "";
            $link_atender = "";
            break;

        case 3: // Cancelado
            $icone_atendimento = "<i class='fa fa-ban fa-2x text-danger' title='Solicitação Cancelada'></i>";
            $link_interacoes = $btn_interacoes;
            $link_cancelar = "";
            $link_atender = "";
            break;
    }

    $pasta = './anexos_solicitacao/' . $solicitacao->id . "_solicitacao";

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
            $onclick = "onclick=\"mostraAnexos($solicitacao->id, '$pasta'); return false;\"";
            $titulo = 'Visualizar anexos';
            $icone_arquivo = "fa fa-folder-open fa-2x text-info";
        }
    }

    $possui_arquivo = $solicitacao->anexos
        ? "<a href='$link_arquivo' target='_blank' title='$titulo' class='d-inline-block' $onclick><i class='$icone_arquivo'></i></a>"
        : "---";

    $solicitante = $manterSolicitacao->getSolicitantePorIdUsuario($solicitacao->solicitante);

    echo "<tr>";

    echo "  <td>" . $solicitacao->id . "</td>";
    echo "  <td>" . $solicitacao->chave . "</td>";
    echo "  <td>" . $solicitacao->setor . "</td>";
    echo "  <td>" . $solicitante . "</td>";
    echo "  <td>" . $solicitacao->descricao . "</td>";

    if ($setor !== 'dijur') {
        echo "  <td>" . $solicitacao->responsavel . "</td>";
    }

    echo "  <td>" . date('d/m/Y H:i', strtotime($solicitacao->data_abertura)) . "</td>";
    echo "  <td align='center'>" . $possui_arquivo . "</td>";
    echo "  <td align='center'>" . $icone_atendimento . "</td>";
    echo "  <td align='center'>"
        . $link_interacoes
        . " "
        . $link_atender
        . " "
        . $link_cancelar
        . "</td>";

    echo "</tr>";
}

