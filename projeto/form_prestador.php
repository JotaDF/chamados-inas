<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_prestador" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Prestador</span>
    </div>  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_prestador.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <input type="hidden" id="op" name="op" value="0"/>
            <div class="form-group row">
                <label for="cnpj" class="col-sm-2 col-form-label">CNPJ:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" name="cnpj" class="form-control form-control-sm" id="cnpj" onkeypress="$(this).mask('00.000.000/0000-00');" placeholder="00.000.000/0000-00" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="razao_social" class="col-sm-2 col-form-label">Razão Social:</label>
                <div class="col-sm-10">
                    <input type="text" name="razao_social" class="form-control form-control-sm" id="razao_social" placeholder="razao_social" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nome_fantasia" class="col-sm-2 col-form-label">Nome Fantasia:</label>
                <div class="col-sm-10">
                    <input type="text" name="nome_fantasia" class="form-control form-control-sm" id="nome_fantasia" placeholder="nome fantasia" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="telefone" class="col-sm-2 col-form-label">Telefone:</label>
                <div class="col-sm-10">
                    <input type="telefone" name="telefone" class="form-control form-control-sm" id="telefone" placeholder="(00)0000-0000">
                </div>
            </div>
            <div class="form-group row">
                <label for="tipo_prestador" class="col-sm-2 col-form-label">Tipo:</label>
                <div class="col-sm-10">
                    <select id="tipo_prestador" name="tipo_prestador" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>
            </div> 
            <div class="form-group row">
                <label for="processo_sei" class="col-sm-2 col-form-label">Processo SEI:</label>
                <div class="col-sm-10">
                    <input type="text" name="processo_sei" class="form-control form-control-sm" id="processo_sei" placeholder="00000-00000000/0000-00">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">Credenciado</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" name="credenciado" type="checkbox" id="credenciado" value="1" checked>
                        <label class="form-check-label" for="credenciado">
                            Sim
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_prestador" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

