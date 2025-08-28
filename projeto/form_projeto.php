<div class="card mb-4 collapse hide border-primary" id="form_projeto" style="max-width:900px">
    <div class="card-header py-2 card-body bg-gradient-primary align-middle">
        <span class="h5 m-0 font-weight text-white">Cadastro de Projeto</span>
        <i class="fa fa-folder text-white"></i>
    </div>
    <div class="card-body">
        <form action="save_projeto.php" method="POST">
            <input type="hidden" id="id_projeto" name="id_projeto" />
            <input type="hidden" id="id_objetivo" name="id_objetivo" />
            <div class="form-group row">
                <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" name="nome" class="form-control form-control-sm" id="nome" placeholder="Nome"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="descricao" class="col-sm-2 col-form-label">Descrição:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" name="descricao" class="form-control form-control-sm"
                        placeholder="Descrição do Projeto" id="descricao" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tap" class="col-sm-2 col-form-label">TAP:</label>
                <div class="col-sm-10">
                    <div style="width: 100%; height: 75px;" id="editor-tap"></div>
                    <input type="hidden" id="tap" name="tap">
                </div>
            </div>
            <div class="form-group row">
                <label for="orcamento" class="col-sm-2 col-form-label">Orçamento:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" onInput="mascaraMoeda(event);" name="orcamento" id="orcamento" placeholder="R$ 0,00"
                        class="form-control form-control-sm" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-2 col-form-label">Objetivo:</label>
                <div class="col-sm-10 input-group">
                    <select name="objetivo" id="objetivo" class="form-control form-control-sm" required>
                        <option value="">Selecione um Objetivo</option>
                    </select>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick=" $('#form_projeto').collapse('hide');" data-toggle="collapse"
                    data-target="#form_projeto" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i>
                    Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </form>

    </div>
</div>