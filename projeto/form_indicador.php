<div class="card mb-3 border-primary" style="width: 800px;">
    <div class="card-body bg-gradient-primary" style="min-height: 5.0rem;">
        <div class="row">
            <div class="col c2 ml-2">
                <div class="h5 mb-0 text-white font-weight-bold">Cadastros de Indicadores</div>
            </div>
            <div class="col-auto">
                <i class="fa fa-compass fa-3x text-white"></i>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="text-xs font-weight-bold text-uppercase mb-1">ID:</div>
                <div class="mb-0"><?= $id_objetivo ?></div>
            </div>
            <div class="col-md-10">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Descrição:</div>
                <div class="mb-0"><?= $objetivo->descricao ?></div>
            </div>
        </div>
        <h6 class="font-weight-bold">Indicador</h6>
        <form id="form_indicador" action="save_indicador.php" method="post" class="row g-3">
            <input type="hidden" name="id_objetivo" value="<?= $id_objetivo ?>" />
            <input type="hidden" name="id_indicador" id="id_indicador" />

            <div class="col-md-6 mb-2">
                <label for="nome" class="form-label ">Nome do Indicador:</label>
                <input type="text" class="form-control form-control-sm" id="nome" name="nome"
                    placeholder="Nome do Indicador" required>
            </div>

            <div class="col-sm-3">
                <label for="unidade" class="form-label">Unidade de medida:</label>
                <input type="text" class="form-control form-control-sm" id="unidade" name="unidade"
                    placeholder="Ex: porcentagem, minutos..." required>
            </div>
            <div class="col-md-3">
                <label for="indicador_desempenho" class="form-label">Indicador de Desempenho:</label>
                <input type="text" class="form-control form-control-sm" id="indicador_desempenho"
                    name="indicador_desempenho" placeholder="Ex: porcentagem, minutos..." required>
            </div>
            <div class="col-md-6 mb-2">
                <label for="periodicidade" class="form-label">Periodicidade:</label>
                <select name="periodicidade" id="periodicidade" class="form-control form-control-sm" required>
                    <option value="">Selecione uma periodicidade</option>
                    <option value="diaria">Diária</option>
                    <option value="semanal">Semanal</option>
                    <option value="quinzenal">Quinzenal</option>
                    <option value="mensal">Mensal</option>
                    <option value="trimestral">Trimestral</option>
                    <option value="semestral">Semestral</option>
                    <option value="anual">Anual</option>
                </select>
            </div>
            <div class="col-md-6 mb-2">
                <label for="tendencia" class="form-label">Tendência:</label>
                <select name="tendencia" id="tendencia" class="form-control form-control-sm" required>
                    <option value="">Selecione uma tendência</option>
                    <option value="crescente">Crescente</option>
                    <option value="decrescente">Decrescente</option>
                    <option value="estavel">Estável</option>
                </select>
            </div>
            <div class="col-md-6 mb-2">
                <label for="fonte" class="form-label">Fonte:</label>
                <div id="editor-fonte" style="height: 100px;"></div>
                <input type="hidden" id="fonte" name="fonte" required>
                <div></div>
            </div>
            <div class="col-md-6">
                <label for="metodologia" class="form-label">Metodologia de Cálculo:</label>
                <div id="editor-metodologia" style="height: 100px;"></div>
                <input type="hidden" id="metodologia" name="metodologia" required>
                <div></div>
            </div>
            <div class="col-md-12 mb-2">
                <label for="linha_base" class="form-label">Linha de Base:</label>
                <div id="editor-linha_base" style="height: 100px;"></div>
                <input type="hidden" id="linha_base" name="linha_base" >
                <div></div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-danger btn-sm" onclick="limpaEditor()">
                    <i class="fas fa-minus-square"></i> Cancelar
                </button>
                &nbsp&nbsp&nbsp
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Salvar
                </button>
            </div>
        </form>

    </div>
</div>