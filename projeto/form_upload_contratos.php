<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_arquivos_contrato" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Enviar arquivos do contrato (<?=$numero . '/' . $ano ?>)</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <div class="card-group">
        <div class="drop-section">Solte seus arquivos aqui</div>
        <button class="file-selector-button">Buscar arquivos</button>
        <input type="file" class="file-selector-input" multiple style="display: none;">
        <button class="upload-all-button" id="uploadButton">Enviar Todos</button>
        <div class="list-section">
            <ul class="list"></ul>
        </div>               
    </div>
    <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_arquivos_contrato" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
            </div>
</div>
<!-- /.container-fluid -->

