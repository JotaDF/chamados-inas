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
            <input type="hidden" id="id" name="id" />
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" oninput="this.value = this.value.toUpperCase()"
                        class="form-control form-control-sm" placeholder="Nome" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="login">Login</label>
                    <input type="text" name="login" id="login" oninput="this.value = this.value.replace(/\s/g, '')"
                        class="form-control form-control-sm" placeholder="Login da rede" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="matricula">Matrícula</label>
                    <input type="text" name="matricula" id="matricula"
                        oninput="this.value = this.value.replace(/\./g, '')" maxlength="8"
                        class="form-control form-control-sm" placeholder="Matrícula" required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control form-control-sm"
                        placeholder="E-mail" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="cargo">Cargo</label>
                    <input type="text" name="cargo" id="cargo" class="form-control form-control-sm" placeholder="Cargo"
                        required>
                </div>
                <div class="form-group col-md-2">
                    <label for="nascimento">Nascimento</label>
                    <input type="date" name="nascimento" id="nascimento" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="simbolo_cargo">Símbolo do Cargo</label>
                    <input type="text" name="simbolo_cargo" id="simbolo_cargo" class="form-control form-control-sm"
                        placeholder="CC-08" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="descricao_lotacao">Descrição Lotação</label>
                    <input type="text" name="descricao_lotacao" id="descricao_lotacao"
                        oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm"
                        placeholder="Unidade de Tecnologia da Informação e Comunicação">
                </div>
                <div class="form-group col-md-3">
                    <label for="codigo_lotacao">Código Lotação</label>
                    <input type="text" name="codigo_lotacao" id="codigo_lotacao" class="form-control form-control-sm"
                        placeholder="30.01.07.04.00.00">
                </div>

                <div class="form-group col-md-4">
                    <label for="setor">Setor</label>
                    <select id="setor" name="setor" class="form-control form-control-sm" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="cargo_efetivo"> Cargo efetivo</label>
                    <input type="text" name="cargo_efetivo" id="cargo_efetivo" class="form-control form-control-sm"
                        placeholder="">
                </div>
                <div class="form-group col-md-3">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control form-control-sm"
                        placeholder="(99) 99999-9999">
                </div>
                <div class="form-group col-md-4">
                    <label for="linkedin">LinkedIn</label>
                    <input type="text" name="linkedin" id="linkedin" class="form-control form-control-sm"
                        placeholder="Link do perfil">
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                    data-target="#form_usuario" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i>
                    Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
    </div>
</div>

