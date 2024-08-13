<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_nota" style="max-width:800px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de nota fiscal</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_nota_pagamento.php" method="post">
            <input type="hidden" id="id_pagamento" name="id_pagamento" value="<?=$obj->id ?>"/>
            <input type="hidden" id="id_prestador" name="id_prestador" value="<?=$prestador->id ?>"/>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="txt_id_pagamento">ID Pagamento:</label>
                <b><span id="txt_id_pagamento"></span></b>
                </div>
                <div class="form-group col-md-3">
                <label for="txt_competencia">Competência:</label>
                <b><span id="txt_competencia"></span></b>
                </div>  
                <div class="form-group col-md-3">
                <label for="txt_informativo">Informativo:</label>
                <b><span id="txt_informativo"></span></b>
                </div>       
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="numero">Nota:<span class="text-danger font-weight-bold">*</span> <span id="msg_nota" class="text-danger font-weight-bold"></span></label>
                <input type="text" name="numero" class="form-control form-control-sm" id="numero" required>
                </div>
                <div class="form-group col-md-3">
                <label for="valor">Valor:<span class="text-danger font-weight-bold">*</span></label>
                <input type="text" class="form-control form-control-sm" onInput="mascaraMoeda(event);" name="valor" id="valor" placeholder="R$ 0,00">
                </div>  
                <div class="form-group col-md-3">
                <label for="exercicio">Exercício:<span class="text-danger font-weight-bold">*</span></label>
                <input type="text" name="exercicio" class="form-control form-control-sm" id="exercicio" required>
                </div>       
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="data_emissao">Data de emissão:<span class="text-danger font-weight-bold">*</span></label>
                <input type="date" name="data_emissao" class="form-control form-control-sm" id="data_emissao" required>
                </div>
                <div class="form-group col-md-3">
                <label for="data_validacao">Data validação:<span class="text-danger font-weight-bold">*</span></label>
                <input type="date" name="data_validacao" class="form-control form-control-sm" id="data_validacao" required>
                </div>          
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_nota" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


