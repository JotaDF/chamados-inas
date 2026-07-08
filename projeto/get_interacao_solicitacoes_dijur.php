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

$possui_arquivo = "";
$titulo = true;
foreach ($lista as $tipo => $obj) {
    $usuario = $manterUsuario->getUsuarioPorId($obj->usuario);

    $interacao = $manterInteracaoSolicitacao->getInteracaoPorId($obj->id); 
    
    $podeExcluir =
        $usuario_logado->id == $interacao->usuario ||
        $usuario_logado->id == $obj->usuario;

    $class_color = "border-left-primary";
    //if ($tipo == 'solicitante') {
    //    $class_color = "border-left-warning ml-4";
    //}
    if($interacao->usuario != $solicitacao->solicitante){
        $class_color = "border-left-warning ml-4";
    }


    $pasta_interacao = './anexos_solicitacao/' . $solicitacao->id . "_solicitacao/interacoes/" . $obj->id;

    $link_arquivo = "#";
    $onclick = "";
    $icone_arquivo = "";
    $totalArquivos = 0;
    $possui_arquivo = "";

    $arquivos = [];

    if (is_dir($pasta_interacao)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($pasta_interacao, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $arquivo) {
            if ($arquivo->isFile()) {
                $arquivos[] = $arquivo->getPathname();
            }
        }

        $totalArquivos = count($arquivos);

        if ($totalArquivos === 1) {
            $link_arquivo = $arquivos[0];
            $possui_arquivo =  "<a href='$link_arquivo' target='_blank' title='Baixar anexo' class='btn btn-info btn-sm d-inline-block'><i class='fa fa-file text-white'></i></a>";
        } elseif ($totalArquivos > 1) {
            $onclick = "onclick=\"mostraAnexos($solicitacao->id, '$pasta_interacao','',$obj->id,true); return false;\"";
            $possui_arquivo =  "<a href='#' target='_blank' title='Visualizar anexos' class='d-inline-block' $onclick><i class='fa fa-folder-open fa-2x text-info'></i></a>";
        }
        if ($podeExcluir && $totalArquivos === 1) {
            $possui_arquivo .= "&nbsp;&nbsp;";
            $possui_arquivo .= "<button type='button' class='btn btn-danger btn-sm' title='Excluir arquivo' onclick=\"excluirArquivo('$solicitacao->id','$pasta_interacao','$link_arquivo')\"><i class='fa fa-times'></i></button>";
        }
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
                    <?php
                    if ($possui_arquivo != "") { ?>
                        <div class="col text-right" style="max-width:20%">
                            <?= $possui_arquivo ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

