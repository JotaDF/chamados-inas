<?php

// include('actions/ManterSlaRegulacao.php');
$manterSlaregulacao = new ManterSlaRegulacao();
$total = $manterSlaregulacao->CountRegistrosRegulacaoTmp();
?>
<!-- Begin Page Content -->

<div class="card mb-4 hide border-primary" id="form_sla_prazo" style="max-width:550px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white"></span>
    </div>

    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_confirmacao_sla" action="#" method="post">
            <!-- Campo oculto para ID -->
            <div id="registros"  >
                <p style="font-size: 15px;">Essa importação trouxe um total  de <strong><?= $total?></strong> Registros.</p>
                <p style="font-size: 15px;">Deseja concluir? </p>
            </div>
            <button type="submit" id="envio" class="btn btn-primary btn-sm" name="envio"><i
                    class="fas fa-save"></i> Concluir </button>
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