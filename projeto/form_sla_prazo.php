
<?php 
include ('actions/ManterSlaPrazo.php');
include ('actions/ManterSlaRegulacao.php');
$manterSlaregulacao = new ManterSlaRegulacao();
$manterSlaPrazo     = new ManterSlaPrazo();
$tipo_guia = $manterSlaPrazo->listarTipoGuia();
$filas     = $manterSlaPrazo->listarFila();
//var_dump($filas); 
//var_dump($tipo_guia); 
?> 
<!-- Begin Page Content -->

<div class="card mb-4 collapse hide border-primary" id="form_sla_prazo" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de prazos</span>
    </div>                  

    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro_sla" action="save_sla_prazo.php" method="post">
            <!-- Campo oculto para ID -->
            <input type="hidden" id="id" name="id" />

            <div class="form-group row g-3">
                <div class="col-sm-4">
                    <label for="competencia" class="col-form-label">Tipo de Guia</label>
                    <select class="form-control" id="tipo_guia" name="tipo_guia" required>
                        <option selected value="0">Selecionar Tipo de Guia</option>
                        <?php foreach ($tipo_guia as $tp): ?>
                            <option value="<?= $tp ?>"><?= $tp ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fila --> 
                <div class="col-sm-4">
                    <label for="informativo" class="col-form-label">Fila</label>
                    <select class="form-control" id="fila" name="fila" required>
                        <option selected value="0">Selecionar Tipo de Fila</option>
                        <?php foreach ($filas as $f): ?>
                            <option value="<?= $f ?>"><?= $f ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label for="prazo" class="col-form-label">Prazo</label>
                    <input type="number" id="prazo" name="prazo" class="form-control" required />
                </div>
            </div>

            <div class="form-group row float-right">
                <!-- Botão para Salvar (Cadastrar) -->
                <button type="submit" id="btn_cadastrar" class="btn btn-primary btn-sm" name="salvar"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;

                <!-- Botão para Alterar -->
                <button type="submit" id="btn_alterar" class="btn btn-warning btn-sm" name="alterar" style="display:none;">
                    <i class="fas fa-edit"></i> Alterar
                </button>
                &nbsp;&nbsp;&nbsp;

                <!-- Botão para Cancelar -->
                <button type="reset" data-toggle="collapse" data-target="#form_sla_prazo" class="btn btn-danger btn-sm">
                    <i class="fa fa-minus-square"></i> Cancelar
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>

