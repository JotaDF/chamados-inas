<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 border-primary" id="form_processo_busca" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Buscar Processos</span>
    </div>
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="processos.php" method="post">
            <input type="hidden" id="nova_busca" name="nova_busca" value="1" />
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="arquivado">Arquivado </label><br/>
                    <input type="checkbox" id="arquivado" name="arquivado" value="1">  
                </div>
                <div class="form-group col-md-2">
                    <label for="inas_parte">INAS é parte </label><br/>
                    <input type="checkbox" id="inas_parte" name="inas_parte" value="1">  
                </div>
                <div class="form-group col-md-3">
                    <label for="pediu_danos">Pediu Danos Morais </label><br/>
                    <input type="checkbox" id="pediu_danos" name="pediu_danos" value="1">
                </div>
                <div class="form-group col-md-5">
                    <label for="senha">Instância </label>
                    <select id="instancia" name="instancia" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="orgao_origem">Órgão de Origem</label>
                    <select id="orgao_origem" name="orgao_origem" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group col-md-7">
                    <label for="classe_judicial">Classe Processual</label>
                    <select id="classe_judicial" name="classe_judicial" class="form-control form-control-sm"
                        onChange="verificaClasse(this.options[this.selectedIndex].value)">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="assunto">Assunto </label>
                    <select id="assunto" name="assunto" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sub_assunto">Sub Assunto </label>
                    <select id="sub_assunto" name="sub_assunto" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sub_assunto">Motivo </label>
                    <select id="motivo" name="motivo" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="liminar">Decisão</label>
                    <select id="liminar" name="liminar" class="form-control form-control-sm"
                        onChange="verificaLiminar(this.options[this.selectedIndex].value)">
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="situacao">Situação Processual </label>
                    <select id="situacao" name="situacao" class="form-control form-control-sm">
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Limpar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-save"></i> Buscar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>
</div>
<!-- /.container-fluid -->