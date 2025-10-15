<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_ementario" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Ementário</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_ementario.php" method="post"> 
            <input type="hidden" id="id" name="id"/>
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>"/>
            <div class="form-group row">
                <div class="input-group">
                    <label for="processo_sei" class="col c0 col-form-label">Processo SEI:</label>
                    <input type="text" name="processo_sei" class="col c1 form-control form-control-sm" id="processo_sei" style="width: 120px;" required>
                </div>
                <div class="input-group">
                    <label for="doc_sei" class=" col c2 col-form-label">DOC SEI:</label>
                    <input type="text" name="doc_sei" class="col c3 form-control form-control-sm" id="doc_sei" style="width: 120px;" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nota_juridica" class="col-sm-2 col-form-label">Nota Jurídica:</label>
                <div class="col-sm-10">
                    <input type="text" name="nota_juridica" class="form-control form-control-sm" id="nota_juridica" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="mb-3 w-100">
                    <label for="ementa" class="form-label">Ementa</label>
                    <div style="width: 100%; height: 75px;" id="editor-ementa"></div>
                    <input type="hidden" name="ementa" id="ementa">
                </div>
            </div>
            <br/>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_ementario" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


