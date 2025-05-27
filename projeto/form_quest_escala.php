<div id="form_quest_escala" class="collapse">
    <div class="card mb-4 border-primary" style="width: 56rem;">
        <div class="card-header bg-gradient-primary">
            <span class="h5 m-0 font-weight text-white">Escala</span>
        </div>
        <div class="card-body">
            <form action="save_quest_escala.php" method="POST">
                <input type="hidden" id="id_quest_escala" name="id_quest_escala">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control form-control-sm" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" class="form-control form-control-sm" id="descricao" name="descricao" required>
                </div>
                <div class="mb-3">
                    <label for="parametro" class="form-label">Parâmentro:</label>
                    <input type="text" class="form-control form-control-sm" id="parametro" name="parametro" required><br/>
                    <span>Exemplos de parâmetros: 
                        <br/>livre <small class="text-muted">(texto livre)</small>
                        <br/>Falso;Verdadeiro <small class="text-muted">(Multipla escolha)</small>
                        <br/>Sim;Não <small class="text-muted">(Multipla escolha)</small>
                        <br/>1;2;3;4;5 <small class="text-muted">(Multipla escolha)</small>
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
