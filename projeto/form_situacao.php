<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_situacao" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Situações Processuais</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_situacao.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="situacao" class="col-sm-2 col-form-label">Situação:</label>
                <div class="col-sm-10">
                    <input type="text" name="situacao" class="form-control form-control-sm" id="situacao" placeholder="Situação" required>
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_situacao" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

