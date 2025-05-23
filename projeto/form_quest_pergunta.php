<div id="form_quest_pergunta" class="collapse">
    <div class="card mb-4 border-primary" style="width: 56rem;">
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
                        <select name="id_quest_escala" class="form-control form-control-sm" id="escalas">
                            <option value="0">Escolha uma escala</option>
                            <?php
                            $manterQuestEscala = new ManterQuestEscala();
                            $escalas = $manterQuestEscala->listar();

                            foreach ($escalas as $e) {
                                ?>
                                <option value="<?= $e->id ?>"><?= htmlspecialchars($e->nome) ?></option>
                                <?php
                            }
                            ;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pergunta_status" class="col-sm-2 col-form-label col-form-label-sm"><strong>Opcional:</strong></label>
                    <div class="col-sm-7">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="opcional" id="opcional"
                                value="1">
                            <label class="form-check-label" for="perguntaSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="opcional" id="opcional"
                                value="0">
                            <label class="form-check-label" for="perguntaNao">Não</label>
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