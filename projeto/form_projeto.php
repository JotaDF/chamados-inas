<div class="card mb-4 border-primary" id="form_planejamento" style="max-width:900px">
    <div class="card-header py-2 card-body bg-gradient-primary align-middle">
        <span class="h6 m-0 font-weight text-white">Cadastro de Projeto</span>
    </div>
    <div class="card-body">
        <form action="save_projeto.php" method="POST">
            <input type="hidden" name="id_planejamento" id="id">
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
                    <input type="hidden" name="tap">
                </div>
            </div>
            <div class="form-group row">
                <label for="orcamento" class="col-sm-2 col-form-label">Orçamento:</label>
                <div class="col-sm-10 input-group" id="editor">
                    <input type="text" name="orcamento" class="form-control form-control-sm" placeholder="Orçamento"
                        id="orcamento" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-2 col-form-label">Status:</label>
                <div class="col-sm-10 input-group" id="editor">
                    <input type="text" name="status" class="form-control form-control-sm" placeholder="Status"
                        id="status" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-2 col-form-label">objetivo:</label>
                <div class="col-sm-10 input-group" id="objetivo">
                    <select name="objetivo" id="objetivo" class="form-control form-control-sm ">
                        <option value="0">Selecione um Objetivo</option>
                    <?php foreach ($objetivos as $o) {
                        ?>
                            <option value="<?=$o->id?>"><?php echo $o->descricao ?></option>
                            <?php } ?>
                        </select>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                    data-target="#form_planejamento" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i>
                    Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </form>

    </div>
    </div>