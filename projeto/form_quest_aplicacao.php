<div id="form_quest_questionario" class="collapse">
    <div class="card mb-4 border-primary" style="width: 56rem;">
        <div class="card-header bg-gradient-primary ">
            <span class="h5 m-0 font-weight text-white">Aplicação</span>
            <i class="fa fa-question-circle fa-2x text-white"></i>
        </div>
        <div class="card-body">
            <form action="save_quest_questionario.php" method="POST">
                <input type="hidden" id="id_quest_questionario" name="id_quest_questionario">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" rows="3"
                        required></textarea>
                </div>
                <div class="form-group row float-right p1">
                    <button type="button"
                        onclick="$('#btn_cadastrar').show(); $('#form_quest_questionario').collapse('hide');"
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