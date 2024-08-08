<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_nota" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Perfil</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_nota_pagamento.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="numero" class="col-sm-2 col-form-label">Nota:</label>
                <div class="col-sm-10">
                    <input type="text" name="numero" class="form-control form-control-sm" id="numero" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="valor" class="col-sm-2 col-form-label">Valor:</label>
                <div class="col-sm-10">
                    <input type="text" name="valor" class="form-control form-control-sm" id="valor" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="valor" class="col-sm-2 col-form-label">Valor:</label>
                <div class="col-sm-10">
                    <input type="text" name="valor" class="form-control form-control-sm" id="valor" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="data_emissao" class="col-sm-2 col-form-label">Data de emissão:</label>
                <div class="col-sm-10">
                    <input type="date" name="exercicio" class="form-control form-control-sm" id="exercicio" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="data_validacao" class="col-sm-2 col-form-label">Data validação:</label>
                <div class="col-sm-10">
                    <input type="date" name="data_validacao" class="form-control form-control-sm" id="data_validacao" required>
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_nota" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


