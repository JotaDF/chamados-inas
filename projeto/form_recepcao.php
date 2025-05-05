<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_recepcao" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Visitas</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_recepcao.php" method="post">
            <input type="hidden" id="usuario" name="usuario" value="<?=$usuario_logado->id ?>"/>
            <input type="hidden" id="id" name="id"/>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="visitante" class="col-form-label">Visitante:</label>
                    <input type="text" name="visitante" class="form-control form-control-sm" id="visitante" placeholder="Visitante" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="empresa" class="col-form-label">Órgão/Empresa:</label>
                    <input type="text" name="empresa" class="form-control form-control-sm" id="empresa" placeholder="Órgão/Empresa" required>
                </div>                
            </div>
            <div class="form-row">
                <div class="form-group col-md-11">
                    <label for="setor" class="col-form-label">Setor:</label>
                    <input type="text" name="setor" class="form-control form-control-sm" id="setor" placeholder="Setor" required>
                </div>
                <div class="form-group col-md-1">
                    <label for="horario" class="col-form-label">Horário:</label>
                    <input type="text" name="horario" onkeypress="$(this).mask('00:00');" class="form-control form-control-sm" id="horario" placeholder="00:00" required>
                </div>                
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="recebido_por" class="col-form-label">Recebido por:</label>
                    <input type="text" name="recebido_por" class="form-control form-control-sm" id="recebido_por" placeholder="Recebido por" required>
                </div>
                <div class="form-group col-md-7">
                    <label for="assunto" class="col-form-label">Assunto:</label>
                    <input type="text" name="assunto" class="form-control form-control-sm" id="assunto" placeholder="Assunto" required>
                </div>                
            </div>
                      
            <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_recepcao" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                 
    </div>
</div>
<!-- /.container-fluid -->

