<div id="form_quest_escala" class="collapse">
    <div class="card mb-4 border-primary" style="width: 50rem;">
        <div class="card-header bg-gradient-primary">
            <span class="h5 m-0 font-weight text-white">Escala</span>
        </div>
        <div class="card-body">
            <form action="save_quest_escala.php" method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                </div>
                <div class="form-group row float-right p1">
                    <button type="reset" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#form_quest_escala">
                        <i class="fa fa-minus-square"></i> Cancelar
                    </button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary btn-sm" name="enviar">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
