<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_processo" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de processo</span>
    </div>                  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_processo.php" method="post" onsubmit="return validarCPF()">
            <input type="hidden" id="usuario" name="usuario" value="<?=$usuario_logado->id ?>"/>
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
                <div class="form-group col-md-5">
                <label for="processo_vinculado">Processo Principal</label>
                <input type="text" class="form-control form-control-sm" name="processo_principal" id="processo_principal" placeholder="00000">
                </div>            
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <label for="guia">Guia/Autorização</label>
                <input type="text" class="form-control form-control-sm" name="guia" id="guia" placeholder="00000000000">
                </div>
                <div class="form-group col-md-2">
                <label for="cpf">CPF <span class="text-danger font-weight-bold">*</span></label>
                <input type="text" onblur="validarCPF(this.value)" onkeypress="$(this).mask('000.000.000-00');" class="form-control form-control-sm" name="cpf" id="cpf" placeholder="000.000.000-00"  required>
                </div>
                <div class="form-group col-md-8">
                <label for="beneficiario">Beneficiário <span class="text-danger font-weight-bold">*</span></label>
                <input type="text" class="form-control form-control-sm" name="beneficiario" id="beneficiario" placeholder="nome" required>
                </div>           
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="assunto">Assunto <span class="text-danger font-weight-bold">*</span></label>
                    <select id="assunto" name="assunto" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>            
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="sub_assunto">Sub Assunto <span class="text-danger font-weight-bold">*</span></label>
                    <select id="sub_assunto" name="sub_assunto" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>            
            </div>
            <div class="form-row">
                <div class="form-group col-md-2.5">
                <label for="valor_causa">Valor da Causa</label>
                <input type="text" class="form-control form-control-sm" onInput="mascaraMoeda(event);" name="valor_causa" id="valor_causa" placeholder="R$ 0,00">
                </div> 
                <div class="form-group col-md-7.5">
                <label for="sub_assunto">Motivo <span class="text-danger font-weight-bold">*</span></label>
                    <select id="motivo" name="motivo" class="form-control form-control-sm" required>
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

