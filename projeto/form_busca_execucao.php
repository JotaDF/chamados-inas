<?php
include_once('actions/ManterCartaRecurso.php');
$manterCartaRecurso = new ManterCartaRecurso();
$exercicio = $manterCartaRecurso->listarExercicio();
?>

<!-- Card Content - Collapse -->
<div class="card-body">
    <form id="form_relatorio" action="relatorio_busca_execucao.php" method="post">
        <input type="hidden" name="usuario_perfil" id="usuario_perfil" value="<?php echo $usuario_logado->perfil?>">
        <div class="col border p-4">
            <fieldset class="form-group">
                <div class="row row-cols-lg-auto g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control form-control-sm " id="cnpj" name="cnpj" placeholder="Digite o CNPJ">
                    </div>
                    <div class="col-md-4">
                        <label for="nf" class="form-label">NF</label>
                        <input type="text" class="form-control form-control-sm" id="nota_fiscal" name="nota_fiscal" placeholder="Número da NF">
                    </div>
                    <div class="col-md-4">
                        <label for="informativo" class="form-label">Informativo</label>
                        <input type="text" class="form-control form-control-sm" id="informativo" name="informativo"
                            placeholder="Informativo">
                    </div>
                    <div class="col-md-4">
                        <label for="competencia" class="form-label">Competência</label>
                        <input type="text" class="form-control form-control-sm" id="competencia" name="competencia"
                            placeholder="MM/AAAA">
                    </div>
                    <div class="col-md-4">
                        <label for="emissao" class="form-label">Emissão da NF</label>
                        <input type="date" class="form-control form-control-sm" id="data_emissao" name="data_emissao"
                            placeholder="Data de Emissão">
                    </div>
                    <br/>
                    <div class="ml-1 w-100">
                    <div class="form-group col-md-10">                    
                        <input type="checkbox" id="adm" name="adm" value="1" /> 
                        <label for="adm"><small>Exibir contratos Administrativos</small></label> 
                    </div>
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
