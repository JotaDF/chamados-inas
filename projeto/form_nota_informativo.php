<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_nota_informativo" style="max-width:800px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de nota informativo</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_nota_informativo.php" method="post" onsubmit="return verificaNotaExiste(<?=$prestador->id ?>)">
            <input type="hidden" id="id_nota_glosa" name="id_nota_glosa" value="<?=$n->id ?>"/>
            <input type="hidden" id="id_prestador"  name="id_prestador" value="<?=$prestador->id ?>"/>
            <input type="hidden" id="id_usuario"    name="id_usuario" value="<?=$usuario_logado->id ?>"/>
            <div class="form-row">
            <div class="form-group col-md-3">
                <label for="txt_id_nota_glosa">ID NOTA GLOSA</label>
                <b><span id="txt_id_nota_glosa"></span></b>
                </div>
                <div class="form-group col-md-3">
                <label for="txt_numero">numero</label>
                <b><span id="txt_numero"></span></b>
                </div>
                <div class="form-group col-md-3">
                <label for="txt_lote">Lote:</label>
                <b><span id="txt_lote"></span></b>
                </div>  
                <div class="form-group col-md-3">
                <label for="txt_valor">Valor:</label>
                <b><span id="txt_valor"></span></b>
                </div>       
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="numero">Carta Informativo:<span class="text-danger font-weight-bold">*</span></label>
                <input type="text" name="carta_informativo" class="form-control form-control-sm" id="carta_informativo" required>
                </div>
                <div class="form-group col-md-3">
                <label for="exercicio">Exercício:<span class="text-danger font-weight-bold">*</span></label>
                <input type="text" name="exercicio" class="form-control form-control-sm" id="exercicio" required>
                </div>       
                <div class="form-group col-md-3">
                <label for="valor">Valor Deferido:<span class="text-danger font-weight-bold">*</span></label>
                <input type="text" class="form-control form-control-sm" onInput="mascaraMoeda(event);" name="valor_deferido" id="valor_deferido" placeholder="R$ 0,00">
                </div>  
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar_info').show();" data-toggle="collapse" data-target="#form_nota_informativo" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->


