<div class="card-body">
    <form id="form_relatorio" action="relatorio_sla_regulacao.php" method="post">
        <div class="col border p-4">
            <fieldset class="form-group">
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="exercicio" class="col-form-label"><strong>Filtrar Por:</strong></label>
                        <select class="form-control form-control-sm w-100" id="filtro" name="filtro">
                                <option value="vazio" name="vazio">SELECIONAR FILTRO</option>
                                <option value="autorizado" name="autorizado">Autorizados</option>
                                <option value="nao_autorizado" name="nao_autorizado">Não Autorizados</option>
                                <option value="todos" name="todos">Todos</option>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>
        <br />
        <div class="form-group row float-right">
            <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Limpar </button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file"></i> Gerar </button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
</div>
</div>