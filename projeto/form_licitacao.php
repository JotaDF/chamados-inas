<div id="form_licitacao" class="collapse">
    <div class="card mb-4 border-primary" style="width: 56rem;">
        <div class="card-header bg-gradient-primary ">
            <span class="h5 m-0 font-weight text-white">Cadastro de Licitação</span>    
        </div>
        <div class="card-body">
            <form action="save_licitacao.php" method="POST">
                <input type="hidden" id="id" name="id">
                <div class="mb-3">
                    <label for="motalidade" class="form-label">Modalidade</label>
                    <input type="text" class="form-control" id="motalidade" name="motalidade" required>
                </div>
                <div class="mb-3">
                    <label for="certame" class="form-label">Certame</label>
                    <input type="text" class="form-control" id="certame" name="certame" required>
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