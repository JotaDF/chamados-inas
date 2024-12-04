<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_evento" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Evento</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_evento.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="titulo" class="col-sm-2 col-form-label">Título:</label>
                <div class="col-sm-10">
                    <input type="text" name="titulo" class="form-control form-control-sm" id="titulo" placeholder="Título" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="descricao" class="col-sm-2 col-form-label">Descrição:</label>
                <div class="col-sm-10">
                    <input type="text" name="descricao" class="form-control form-control-sm" id="descricao" placeholder="Descrição" required>
                </div>
            </div>
            <div class="col border">
                <fieldset class="form-group form-inline">
                    <legend class="col c1 col-form-label pt-0">Realização</legend>
                    <div class="input-group">
                        <label for="data" class="col c0 col-form-label">Data:</label>
                        <input type="date" name="data" class="col c1 form-control form-control-sm" id="data" style="width: 120px;" required>
                    </div>
                    <div class="input-group">
                        <label for="hora" class=" col c2 col-form-label">Hora:</label>
                        <input type="time" name="hora" class="col c3 form-control form-control-sm" id="hora" style="width: 80px;" required>
                    </div>
                </fieldset>  
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                Permitir inscrição: <input type="checkbox" name="inscreve" id="inscreve">
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_evento" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


