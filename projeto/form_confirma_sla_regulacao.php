<?php

// include('actions/ManterSlaRegulacao.php');
$manterSlaregulacao = new ManterSlaRegulacao();
$total = $manterSlaregulacao->CountRegistrosRegulacaoTmp();
$regulacao = $manterSlaregulacao->listaSlaRegulacaoTemporaria();
?>
<!-- Begin Page Content -->

<div  id="form_sla_prazo" style="max-width: 100%">
    <!-- Card Header - Accordion -->
    <div class="card-header py-1 card-body bg-gradient-primary " style="min-height: 0.8rem;">
        <span class="h6 m-0 font-weight text-white"></span>
    </div>

    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_confirmacao_sla" action="confirma_regulacao_tmp.php" method="post">
            <!-- Campo oculto para ID -->
            <div id="registros"  >
                <p style="font-size: 15px;">Essa importação trouxe um total  de <strong><?= $total?></strong> Registros.</p>
            </div>
            <button type="submit" id="envio" class="btn btn-primary btn-sm" name="envio"> Confirmar </button>
            &nbsp;&nbsp;&nbsp;

            <!-- Botão para Cancelar -->
            <button type="submit" name="cancelar" id="cancelar" data-target="#form_sla_prazo" class="btn btn-danger btn-sm">
                <i class="fa fa-minus-square"></i> Cancelar
            </button>
            <div class="form-group row float-right">
                <!-- Botão para Salvar (Cadastrar) -->
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>

</div>