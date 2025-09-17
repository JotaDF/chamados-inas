<div class="card mb-4 collapse hide border-primary" id="form_feriados" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Cadastro de Feriados</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_feriado.php" method="post">
            <input type="hidden" id="id" name="id" />
            <div class="row">
                <!-- Campo Data -->
                <div class="col-md-3 mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" name="data" id="data" class="form-control form-control-sm" required>
                </div>

                <!-- Campo Descrição -->
                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" class="form-control form-control-sm"
                        placeholder="Descrição" required>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_feriados"
                    class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>
</div>