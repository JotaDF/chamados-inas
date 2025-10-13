<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" style="max-width: 900px;" id="form_tarefa">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Cadastro de Tarefa</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_tarefa.php" method="post">
            <input type="hidden" id="id" name="id" />
            <input type="hidden" id="id_criador" name="criador" value="<?= $usuario_logado->id ?>" />
            <input type="hidden" id="duplicar" name="duplicar" value="0" />

            <div class="form-group">
                <label for="nome" class="form-label small">Nome:</label>
                <input type="text" name="nome" class="form-control form-control-sm" id="nome" placeholder="Nome"
                    required>
            </div>
            <div class="form-group">
                <label for="descricao" class="form-label small">Descrição:</label>
                <div style="width: 100%; height: 75px;" id="editor-descricao"></div>
                <input type="hidden" id="descricao" name="descricao">
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="inicio" class="form-label small">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="termino" class="form-label small">Tipo:</label>
                    <select id="tipo" name="tipo" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <?php if ($usuario_logado->perfil == 1 || $usuario_logado->perfil == 2 || $usuario_logado->perfil == 11) {
                ?>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="responsavel" class="v">Responsável:</label>
                        <select id="responsavel" name="responsavel" class="form-control form-control-sm">
                            <option value="">Selecione</option>
                        </select>
                    </div>
                        <div class="col-md-6">
                            <label for="equipe" class="form-label small">Equipe:</label>
                            <select id="equipe" name="equipe" class="form-control form-control-sm"
                                onChange="atualizaUsuarios(this.options[this.selectedIndex].value)">
                                <option value="0"> Todos </option>
                            </select>
                        </div>
                    </div>
                <?php
            } else {
            ?>
            <div class="form-group row">
                <div class="col-12">
                    <label for="responsavel" class="form-label small">Responsável:</label>
                    <select id="responsavel" name="responsavel" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <?php } ?>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="inicio" class="form-label small">Início:</label>
                    <input type="date" name="inicio" class="form-control form-control-sm" id="inicio" required>
                </div>
                <div class="col-md-6">
                    <label for="termino" class="form-label small">Término:</label>
                    <input type="date" name="termino" class="form-control form-control-sm" id="termino" required>
                </div>
            </div>




            <div class="form-group text-end">
                <button type="reset" onclick="cancelar()" data-toggle="collapse" data-target="#form_tarefa"
                    class="btn btn-danger btn-sm">
                    <i class="fa fa-minus-square"></i> Cancelar
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Salvar
                </button>
            </div>
        </form>


    </div>
</div>
<!-- /.container-fluid -->