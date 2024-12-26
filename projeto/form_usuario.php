<!-- Begin Page Content -->

<!-- Collapsable Form -->
<div class="card mb-4 collapse hide border-primary" id="form_usuario" style="max-width:900px">
    <!-- Card Header - Accordion -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">               
        <span class="h6 m-0 font-weight text-white">Cadastro de Usuário</span>
    </div>  
    <!-- Card Content - Collapse -->
    <div class="card-body">
        <form id="form_cadastro" action="save_usuario.php" method="post">
            <input type="hidden" id="id" name="id"/>
            <div class="form-group row">
                <label for="login" class="col-sm-2 col-form-label">Login:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" name="login" class="form-control form-control-sm" id="login" placeholder="login da rede" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="matricula" class="col-sm-2 col-form-label">Matrícula:</label>
                <div class="col-sm-10">
                    <input type="text" name="matricula" class="form-control form-control-sm" id="matricula" placeholder="matricula" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="cargo" class="col-sm-2 col-form-label">Cargo:</label>
                <div class="col-sm-10">
                    <input type="text" name="cargo" class="form-control form-control-sm" id="cargo" placeholder="matricula" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                <div class="col-sm-10">
                    <input type="text" name="nome" class="form-control form-control-sm" id="nome" placeholder="nome" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">E-mail:</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control form-control-sm" id="email" placeholder="e-mail" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nascimento" class="col-sm-2 col-form-label">Nascimento:</label>
                <div class="col-sm-10">
                    <input type="date" name="nascimento" class="form-control form-control-sm" id="nascimento" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="whatsapp" class="col-sm-2 col-form-label">WhatsApp:</label>
                <div class="col-sm-10">
                    <input type="text" name="whatsapp" class="form-control form-control-sm" id="whatsapp">
                </div>
            </div>
            <div class="form-group row">
                <label for="linkedin" class="col-sm-2 col-form-label">LinkedIn:</label>
                <div class="col-sm-10">
                    <input type="text" name="linkedin" class="form-control form-control-sm" id="linkedin">
                </div>
            </div>
            <div class="form-group row">
                <label for="setor" class="col-sm-2 col-form-label">Setor:</label>
                <div class="col-sm-10">
                    <select id="setor" name="setor" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>    
                    </select>
                </div>
            </div> 
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse" data-target="#form_usuario" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i> Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>                  
    </div>
</div>
<!-- /.container-fluid -->

