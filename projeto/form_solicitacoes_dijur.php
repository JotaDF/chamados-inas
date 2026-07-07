<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4  border-primary" id="form_solicitacoes_dijur" style="width:1000px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Nova Solicitação DIJUR</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_solicitacoes" action="save_solicitacao.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="setor" name="setor" value="<?= $sigla ?>">
            <input type="hidden" id="solicitante" name="solicitante" value="<?= $usuario_logado->id ?>">
            <!-- <?php if ($usuario_logado->perfil == "x") { ?>
                <div class="form-group row">
                    <label for="setor" class="col-sm-2 col-form-label">Setor</label>
                    <div class="col-sm-10">
                        <select id="setor" name="setor" class="form-control form-control-sm" required>
                            <option value="">Selecione </option>
                        </select>
                    </div>
                </div>
            <?php } ?> -->
            <div class="form-group row">
                <label for="processo" class="col-sm-2 col-form-label">Processo: <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" id="chave" name="chave" class="form-control form-control-sm"
                        placeholder="Número do processo" required> 
                </div>
            </div>
            <div class="form-group row">
                <label for="assunto" class="col-sm-2 col-form-label">Parte autora:</label>
                <div class="col-sm-10">
                    <input type="text" id="assunto" name="assunto" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <label for="descricao" class="col-sm-2 col-form-label">Descrição da solicitação: <span class="text-danger">*</span></label>
                <div class="col-sm-10 mb-5">
                    <div id="editor"></div>
                    <input type="hidden" name="descricao" id="descricao">
                </div>
            </div>
            <div class="form-group row">
                <label for="descricao" class="col-sm-2 col-form-label">Arquivo:</label>
                <div class="col-sm-10">
                    <div id="container-anexos">
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="anexo_0" name="anexos[]">
                            <label class="custom-file-label" for="anexo_0">
                                Escolher arquivo...
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Você pode anexar mais de um arquivo. Um novo campo será exibido automaticamente após a
                            seleção de um arquivo.
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-target="#form_solicitacoes_dijur"
                    class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->