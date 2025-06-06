<div id="form_quest_pergunta" class="collapse">
    <div class="card mb-4 border-primary" style="max-width:1200px">
        <div class="card-header bg-gradient-primary">
            <span class="h5 m-0 font-weight text-white">Cadastro de Pergunta</span>
        </div>
        <div class="card-body">
            <form action="save_quest_pergunta.php" method="POST">
                <div class="row mb-3">
                    <input type="hidden" name="id_quest_pergunta" id="id_quest_pergunta">
                    <label for="titulo"
                        class="col-sm-2 col-form-label col-form-label-sm"><strong>Título:</strong></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" id="titulo" name="titulo"
                            placeholder="Título da pergunta">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSm"
                        class="col-sm-2 col-form-label col-form-label-sm"><strong>Pergunta:</strong></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-sm" id="pergunta" name="pergunta"
                            placeholder="Pergunta">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm"><strong>Tipo de
                            Escala:</strong></label>
                    <div class="col-sm-7">
                        <select id="escala" name="escala" class="form-control form-control-sm" required>
                            <option value="">Selecione uma escala</option>    
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pergunta_status" class="col-sm-2 col-form-label col-form-label-sm"><strong>Opcional:</strong></label>
                    <div class="col-sm-7">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="opcional" name="opcional" value="1">
                        </div>
                    </div>
                </div>

                <div class="form-group row float-right p1">
                    <button type="reset" class="btn btn-danger btn-sm" data-toggle="collapse"
                        data-target="#form_quest_pergunta">
                        <i class="fa fa-minus-square"></i> Cancelar
                    </button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary btn-sm" id="enviar" name="enviar">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>