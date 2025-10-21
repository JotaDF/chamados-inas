<!-- Card Content - Collapse -->
<div class="card-body">
    <form id="form_relatorio" action="relatorio_busca_periodo_execucao.php" method="post">
        <input type="hidden" name="usuario_perfil" id="usuario_perfil" value="<?php echo $usuario_logado->perfil?>">
        <div class="col border p-4">
            <fieldset class="form-group">
                <div class="row row-cols-lg-auto g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="termino" class="col-form-label"><strong>Tipo</strong></label>
                        <select class="form-control form-control-sm w-100" id="filtro" name="filtro">
                            <option value="data_executado">Data de Execução</option>
                            <option value="data_atesto">Data de Atesto</option>
                            <option value="data_pagamento">Data de Pagamento</option>
                            <option value="data_emissao">Data de Emissão da Nota</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inicio" class="form-label"><strong>Data início</strong></label>
                        <input type="date" class="form-control form-control-sm" id="inicio" name="inicio"
                            placeholder="Data de Emissão">
                    </div>
                    <div class="col-md-4">
                        <label for="termino" class="form-label"><strong>Data término</strong></label>
                        <input type="date" class="form-control form-control-sm" id="termino" name="termino"
                            placeholder="Data de término">
                    </div>
                </div>
                <br/>
                <div class="form-row">
                    <div class="form-group col-md-10">                    
                        <input type="checkbox" id="adm" name="adm" value="1" /> 
                        <label for="adm"><small>Exibir contratos Administrativos</small></label> 
                    </div>
                </div>
            </fieldset>
        </div>

        <br />
        <div class="form-group row float-right">
            <button type="reset" class="btn btn-danger btn-sm" ><i class="fa fa-refresh"></i> Limpar </button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-file"></i>Gerar</button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
</div>
</div>
