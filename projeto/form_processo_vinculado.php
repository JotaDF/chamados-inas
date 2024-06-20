<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_processo" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de processo vinculado</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_processo.php" method="post">
            <input type="hidden" id="usuario" name="usuario" value="<?=$usuario_logado->id ?>"/>
            <input type="hidden" id="id_principal" name="id_principal" />
            <input type="hidden" id="processo_principal" name="processo_principal" />
            <input type="hidden" id="cpf" name="cpf" />
            <input type="hidden" id="beneficiario" name="beneficiario" />
            <input type="hidden" id="guia" name="guia" />
            <input type="hidden" id="assunto" name="assunto" />
            <input type="hidden" id="valor_causa" name="valor_causa" />
            <input type="hidden" id="id" name="id"/>
            <div class="form-row">
                <div class="form-group col-md-5">
                <label for="numero">Número <span class="text-danger font-weight-bold">*</span></label>
                <input type="text" class="form-control form-control-sm" name="numero" id="numero" placeholder="00000" required>
                </div>
                <div class="form-group col-md-3">
                <label for="autuacao">Autuação <span class="text-danger font-weight-bold">*</span></label>
                <input type="date" class="form-control form-control-sm" name="autuacao" id="autuacao" required>
                </div>
                <div class="form-group col-md-4">
                <label for="senha">Instância <span class="text-danger font-weight-bold">*</span></label>
                    <select id="instancia" name="instancia" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>                
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="sei_t">SEI</label>
                <input type="text" class="form-control form-control-sm" name="sei_t" id="sei_t" placeholder="0000">
                </div>
                <div class="form-group col-md-1 mt-4">
                    <a class="btn btn-warning btn-sm" onclick="addSei()" href="#">+</a>
                </div> 
                <div class="form-group col-md-8">
                <label for="sei_t">Adicionados</label>
                    <br/><span id="txt_sei"> </span>
                    <input class="form-control form-control-sm" type="hidden" id="sei" name="sei" value="" readonly/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                <label for="classe_judicial">Classe Judicial</label>
                    <select id="classe_judicial" name="classe_judicial" class="form-control form-control-sm" onChange="verificaClasse(this.options[this.selectedIndex].value)" >
                        <option value="">Selecione</option>    
                    </select>
                </div>          
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="liminar">liminar</label>
                    <select id="liminar" name="liminar" class="form-control form-control-sm" onChange="verificaLiminar(this.options[this.selectedIndex].value)">
                        <option value="">Selecione</option>    
                    </select>
                </div>
                <div class="form-group col-md-3">
                <label for="data_cumprimento_liminar">Cumprimento Liminar</label>
                <input type="date" class="form-control form-control-sm" name="data_cumprimento_liminar" id="data_cumprimento_liminar">
                </div>
                <div class="form-group col-md-5">
                <label for="situacao">Situação Processual <span class="text-danger font-weight-bold">*</span></label>
                    <select id="situacao" name="situacao" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>            
            </div>  
            <div class="form-row mb-2">
                <div class="form-row w-100">
                <label for="observacoes ">Observações </label>
                <textarea class="form-control form-control-sm" name="observacoes" id="observacoes" rows="3"></textarea><br/>
                </div>           
            </div>           
            <div class="form-group row float-right">
                <button type="reset" data-toggle="collapse" data-target="#form_processo" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

