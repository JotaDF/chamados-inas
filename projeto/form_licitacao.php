<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_licitacao" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Licitação</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_licitacao.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="modalidade" class="col-sm-2 col-form-label">Modalidade:</label>
                <div class="col-sm-10">
                    <input type="text" name="modalidade" class="form-control form-control-sm" id="modalidade"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="certame" class="col-sm-2 col-form-label">Certame:</label>
                <div class="col-sm-10">
                    <input type="text" name="certame" class="form-control form-control-sm" id="certame"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ano" class="col-sm-2 col-form-label">Ano:</label>
                <div class="col-sm-10">
                    <input type="text" name="ano" class="form-control form-control-sm" id="ano"  required>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_licitacao" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


