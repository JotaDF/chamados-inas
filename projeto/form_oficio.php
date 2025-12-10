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
            <input type="hidden" id="setor" name="setor" value="<?=$origem ?>"/>
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$usuario_logado->id ?>"/>
            
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="processo">Processo SEI <span class="text-danger font-weight-bold">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="processo" id="processo"
                        placeholder="00000-00000000/0000-00" required <?=$disable ?>>
                </div>
                <div class="form-group col-md-4">
                    <label for="link_sei">Link SEI <span class="text-danger font-weight-bold">*</span></label>
                    <input type="text" name="link_sei" class="form-control form-control-sm" id="link_sei" required <?=$disable ?>>
                </div>
                <div class="form-group col-md-3">
                    <label for="enviado">Enviado em <span class="text-danger font-weight-bold">*</span></label>
                    <input type="date" class="form-control form-control-sm" name="enviado" id="enviado" required <?=$disable ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="numero">Número do Ofício <span class="text-danger font-weight-bold">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="numero" id="numero" required <?=$disable ?>>
                </div>
                <div class="form-group col-md-4">
                    <label for="origem">Origem <span class="text-danger font-weight-bold">*</span></label>
                    <input type="text" name="origem" class="form-control form-control-sm" id="origem" required <?=$disable ?>>
                </div>
                <div class="form-group col-md-3">
                    <label for="destino">Destinatário <span class="text-danger font-weight-bold">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="destino" id="destino" required <?=$disable ?>>
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col-sm-12">
                    <label for="assunto">Assunto </label>
                    <div style="width: 100%; height: 95px;" id="editor"></div>
                    <input type="hidden" name="assunto" id="assunto" rows="3" <?=$disable ?>><br />
                </div>
            </div>

            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_oficio" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm" <?=$disable ?>><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

