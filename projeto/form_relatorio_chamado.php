<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 border-primary" style="max-width: 900px;">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Filtro de relatório</span>
    </div>                
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_relatorio" action="relatorio_chamado.php" method="post">                       
            <div class="col border">
                <fieldset class="form-group form-inline">
                    <legend class="col c1 col-form-label pt-0">Período</legend>
                    <div class="input-group" style="width: 300px">
                        <label for="inicio" class="col c0 col-form-label">Data inicial:</label>
                        <input type="date" name="inicio" class="col c1 form-control form-control-sm" id="inicio">
                    </div>
                    <div class="input-group" style="width: 300px">
                        <label for="termino" class=" col c2 col-form-label">Data final:</label>
                        <input type="date" name="termino" class="col c3 form-control form-control-sm" id="termino">
                    </div>
                </fieldset>  
            </div>
            <br/>
            <div class="form-group row float-right">
                <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Limpar </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file"></i> Gerar </button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->
