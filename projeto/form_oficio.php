<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_oficio" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Ofícios</span>
    </div>  
    <!-- Card Content - Collapse -->
     <?php
     require_once('./actions/ManterSetor.php');
     $db_setor = new ManterSetor();
     $setor = $db_setor->getSetorPorId($usuario_logado->setor);
     $array_setor = explode("/", $setor->sigla);
     $origem  = "";
     if (count($array_setor) > 1) {
        if($array_setor[1] == "DIPLAS" or $array_setor[1] == "DIAD" or $array_setor[1] == "DIJUR" or $array_setor[1] == "DIFIN" ){
            $origem = trim($array_setor[0] . "/" . $array_setor[1]);
        } else {
            $origem = trim($array_setor[0]);
        }
     } else {
         $origem = trim($array_setor[0]);
     }
     ?>
    <div class="card-body">
        <form id="form_cadastro" action="save_oficio.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <input type="hidden" id="origem" name="origem" value="<?=$origem ?>?>"/>
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>?>"/>
            <div class="form-group row">
                <label for="processo" class="col-sm-2 col-form-label">Processo SEI:</label>
                <div class="col-sm-10">
                    <input type="text" name="processo" class="form-control form-control-sm" id="processo" placeholder="00000-00000000/0000-00">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_sei" class="col-sm-2 col-form-label">Link SEI:</label>
                <div class="col-sm-10">
                    <input type="text" name="link_sei" class="form-control form-control-sm" id="link_sei" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="numero" class="col-sm-2 col-form-label">Número:</label>
                <div class="col-sm-10">
                    <input type="text" name="numero" class="form-control form-control-sm" id="numero" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="assunto" class="col-sm-2 col-form-label">Assunto:</label>
                <div class="col-sm-10">
                    <input type="telefone" name="assunto" class="form-control form-control-sm" id="assunto" required>
                </div>
            </div>
             <div class="form-group row">
                <label for="destino" class="col-sm-2 col-form-label">Destinatário:</label>
                <div class="col-sm-10">
                    <input type="text" name="destino" class="form-control form-control-sm" id="destino" required>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_oficio" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

