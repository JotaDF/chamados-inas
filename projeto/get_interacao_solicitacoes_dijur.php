<?php
include_once('actions/ManterInteracaoSolicitacao.php');
include_once('actions/ManterUsuario.php');

$manterInteracaoSolicitacao = new ManterInteracaoSolicitacao();
$manterUsuario = new ManterUsuario();

$lista = $manterInteracaoSolicitacao->listarInteracoesPorSolicitacao($id_solicitacao);
// $lista = [
//     'atendente' => ['texto' => 'Informa que sua solicitação será atendida!', 'data' => '21/05/2026', 'usuario' => 'Cauê Edi de Souza e Braga'],
//     'solicitante' => ['texto' => 'Realizo essa solicitação por...', 'data' => '21/05/2026', 'usuario' => 'José Wilson da Costa']
// ];

$pasta = './anexos_solicitacao/' . $solicitacao->id . "_solicitacao";

$link_arquivo = "";
$totalArquivos = 0;
$link_arquivo = "#";
$onclick = "";
$titulo = "";

if (is_dir($pasta)) {

    $arquivos = array_values(array_diff(scandir($pasta), ['.', '..']));

    $totalArquivos = count($arquivos);

    if ($totalArquivos === 1) {
        $link_arquivo = $pasta . '/' . $arquivos[0];
        $titulo = 'Baixar anexo';
        $icone_arquivo = "fa fa-file fa-2x text-info";
    } else {
        $onclick = "onclick=\"mostraAnexos($solicitacao->id, '$pasta'); return false;\"";
        $titulo = 'Visualizar anexos';
        $icone_arquivo = "fa fa-folder-open fa-2x text-info";
    }
}


$titulo = true;
foreach ($lista as $tipo => $obj) {
    $usuario = $manterUsuario->getUsuarioPorId($obj->usuario);

    $interacao = $manterInteracao->getInteracaoPorId(76);
    
    $podeExcluir =
        $usuario_logado->id == $interacao->usuario ||
        $usuario_logado->id == $obj->solicitante;

    $class_color = "border-left-primary";
    if ($tipo == 'solicitante') {
        $class_color = "border-left-warning ml-4";
    }

    if ($titulo) {
        ?>
        <div class="col-xl-3 col-md-6 mb-2" style="max-width: 750px;">
            <span class="h6">INTERAÇÕES</span>
        </div>
        <?php
        $titulo = false;
    }
    ?>

    <div class="col-xl-3 col-md-6 mb-2" style="max-width: 750px;">
        <div class="card <?= $class_color ?> shadow py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <span class="text-xs font-weight-bold text-uppercase"
                            id="titulo_interacao"><?= $usuario->nome ?></span><br />
                        <div><?= $obj->texto ?></div>
                        <div><code class="highlighter-rouge"><i><?= date('d/m/Y H:i', strtotime($obj->data)) ?></i></code>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

