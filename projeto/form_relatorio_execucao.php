<?php
include_once('actions/ManterCartaRecurso.php');
$manterCartaRecurso = new ManterCartaRecurso();
$exercicio = $manterCartaRecurso->listarExercicio();
?>

<!-- Card Content - Collapse -->
<div class="card-body">
    <form id="form_relatorio" action="relatorio_execucao.php" method="post">
        <div class="col border p-4">
            <fieldset class="form-group">
                <legend class="col-form-label h5" style="font-size: 22px;">Período</legend>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="exercicio" class="col-form-label"><strong>Exercicio</strong></label>
                        <select class="form-select form-select-sm w-100" id="exercicio" name="exercicio">
                            <?php foreach ($exercicio as $e) { ?>
                                <option value="<?= $e ?>" name="['exercicio']"><?= $e ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="termino" class="col-form-label"><strong>Filtro</strong></label>
                        <select class="form-select form-select-lg  w-100" id="filtro" name="filtro">
                            <option value="nota_glosa" name="nota_glosa">Nota de Glosa</option>
                            <option value="nota_pagamento" name="nota_pagamento" >Nota de Pagamento</option>
                            <option value="todos">Todos</option>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>

        <br />
        <div class="form-group row float-right">
            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Limpar </button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file"></i> Gerar </button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
</div>
</div>