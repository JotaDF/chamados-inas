<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_beneficiario" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Cadastro de Beneficiário</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_beneficiario.php" method="post">
            <div class="form-group row">
                <label for="Nome" class="col-sm-2 col-form-label "><b>CPF:</b></label>
                <div class="col-sm-10 mb-1">
                    <input type="text" class="form-control form-control-sm" name="cpf" id="cpf" readonly>
                </div>
                <label for="Nome do médico" class="col-sm-2 col-form-label "><b>Carteirinha:</b></label>
                <div class="col-sm-10 mb-1">
                    <input type="text" class="form-control form-control-sm" name="carteirinha" id="carteirinha" readonly>
                </div>
                <label for="Nome" class="col-sm-2 col-form-label"><b>Nome:</b></label>
                <div class="col-sm-10 mb-1">
                    <input type="text" class="form-control form-control-sm" name="nome" id="nome" readonly>
                </div>
                <label for="Nome do médico" class="col-sm-2 col-form-label "><b>Telefone:</b></label>
                <div class="col-sm-10 mb-1">
                    <input type="text" class="form-control form-control-sm" name="telefone" id="telefone">
                </div>
                <label for="Nome do médico" class="col-sm-2 col-form-label"><b>Email:</b></label>
                <div class="col-sm-10 mb-1">
                    <input type="text" class="form-control form-control-sm" name="email" id="email">
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                    data-target="#form_beneficiario" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i>
                    Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->