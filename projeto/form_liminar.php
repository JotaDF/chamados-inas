<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_liminar" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de tipo de decisão</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_liminar.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="tipo" class="col-sm-2 col-form-label">Tipo:</label>
                <div class="col-sm-10">
                    <input type="text" name="tipo" class="form-control form-control-sm" id="tipo" placeholder="Tipo" required>
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_liminar" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

