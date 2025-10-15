<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_chamado" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Novo chamado</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_chamado.php" method="post">
            <div class="form-group row">
                <label for="usuario" class="col-sm-2 col-form-label">Usuário:</label>
                <div class="col-sm-10">
                        <input type="hidden" name="red" value="meus_chamados.php"/>
                        <input type="hidden" name="usuario" value="<?=$usuario_logado->id ?>"/>
                        <?=$usuario_logado->nome ?>
                </div>
            </div> 
            <div class="form-group row">
                <label for="descricao" class="col-sm-2 col-form-label">Descrição da solicitação:</label>
                <div class="col-sm-10 mb-5">
                    <div id="editor"></div>
                    <input type="hidden" name="descricao" id="descricao">
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_chamado" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->
