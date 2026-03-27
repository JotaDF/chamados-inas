<div class="card mb-4 collapse hide border-primary" id="form_agenda_pericia" style="max-width:900px">

    <!-- Header -->
    <div class="card-header py-2 card-body bg-gradient-primary align-middle" style="min-height: 2.5rem;">
        <span class="h6 m-0 font-weight text-white">Horários de atendimento</span>
    </div>

    <!-- Body -->
    <div class="card-body">
        <form id="formAgendaPericia" action="save_config_agenda_pericia.php" method="POST">

            <input type="hidden" id="id_agenda_pericia" name="id_agenda_pericia">
            <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $usuario_logado->id ?>">

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control form-control-sm" id="nome" name="nome">
                </div>
            </div>
            <!-- MATUTINO -->
            <h6 class="text-primary font-weight-bold mb-3">Período Matutino</h6>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="matutino_inicio">Início</label>
                    <input type="time" class="form-control form-control-sm" id="matutino_inicio" name="matutino_inicio">
                </div>

                <div class="form-group col-md-3">
                    <label for="matutino_fim">Fim</label>
                    <input type="time" class="form-control form-control-sm" id="matutino_fim" name="matutino_fim">
                </div>

                <div class="form-group col-md-3">
                    <label for="matutino_intervalo">Intervalo (min)</label>
                    <input type="number" class="form-control form-control-sm" id="matutino_intervalo"
                        name="matutino_intervalo" min="0">
                </div>
            </div>

            <hr>

            <!-- VESPERTINO -->
            <h6 class="text-primary font-weight-bold mb-3">Período Vespertino</h6>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="vespertino_inicio">Início</label>
                    <input type="time" class="form-control form-control-sm" id="vespertino_inicio"
                        name="vespertino_inicio">
                </div>

                <div class="form-group col-md-3">
                    <label for="vespertino_fim">Fim</label>
                    <input type="time" class="form-control form-control-sm" id="vespertino_fim" name="vespertino_fim">
                </div>

                <div class="form-group col-md-3">
                    <label for="vespertino_intervalo">Intervalo (min)</label>
                    <input type="number" class="form-control form-control-sm" id="vespertino_intervalo"
                        name="vespertino_intervalo" min="0">
                </div>
            </div>

            <!-- BOTÕES -->
            <div class="d-flex justify-content-end mt-3">
                <button type="reset" onclick="$('#btn_abrir_agenda').show();" data-toggle="collapse"
                    data-target="#form_agenda_pericia" class="btn btn-danger btn-sm  mr-2">
                    <i class="fa fa-times"></i> Cancelar
                </button>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Salvar
                </button>
            </div>

        </form>
    </div>

</div>