<div id="form_licitacao" class="collapse">
    <div class="card mb-4 border-primary" style="width: 56rem;">
        <div class="card-header bg-gradient-primary ">
            <span class="h5 m-0 font-weight text-white">Cadastro de Licitação</span>    
        </div>
        <div class="card-body">
            <form action="save_licitacao.php" method="POST">
                <input type="hidden" id="id" name="id">
                <div class="mb-3">
                    <label for="modalidade" class="form-label">Modalidade</label>
                    <input type="text" class="form-control" id="modalidade" name="modalidade" required>
                </div>
                <div class="mb-3">
                    <label for="certame" class="form-label">Certame</label>
                    <input type="text" class="form-control" id="certame" name="certame" required>
                </div>
                <div class="mb-3">
                    <label for="objeto" class="form-label">Objeto</label>

                    <div style="width: 100%; height: 75px;" id="editor-objeto"></div>
                    <input type="hidden" name="objeto" id="objeto">
                </div>
                <div class="mb-3">
                    <label for="ano" class="form-label">Ano</label>
                    <input type="text" class="form-control" id="ano" name="ano" required>
                </div>
                <div class="form-group row float-right p1">
                    <button type="button"
                        onclick="$('#btn_cadastrar').show(); $('#form_licitacao').collapse('hide');"
                        class="btn btn-danger btn-sm">
                        <i class="fa fa-minus-square"></i> Cancelar
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary btn-sm mr-1" name="enviar"><i class="fas fa-save"></i>
                        Salvar</button>
                    &nbsp;&nbsp;&nbsp;
                </div>
            </form>
        </div>
    </div>
</div>