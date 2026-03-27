<form action="executar_atendimento_pericia.php" method="POST" id="form_atendimento">
    <input type="hidden" name="id_usuario" value="<?= $usuario_logado->id ?>">
    <input type="hidden" name="data_agendada" id="dataAgendada">
    <input type="hidden" name="hora_agendada" id="horaAgendada">
    <input type="hidden" name="id_fila" id="id_fila">
    <input type="hidden" name="id_atendimento" id="id_atendimento">

    <!-- DADOS DO BENEFICIÁRIO -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Nome</div>
                <div id="nome_beneficiario"><?= $dados->nome ?></div>
                <div id="nome_agendado"></div>
                <input type="hidden" name="nome" value="<?= $dados->nome ?>">
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">CPF</div>
                <div id="cpf_beneficiario"><?= $dados->cpf ?></div>
                <div id="cpf_agendado"></div>
                <input type="hidden" name="cpf" value="<?= $dados->cpf ?>">
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Telefone</div>
                <div id="telefone_beneficiario"><?= $dados->telefone ?></div>
                <div id="telefone_agendado"></div>
                <input type="hidden" name="telefone" id="telefone" value="<?= $dados->telefone ?>">
            </div>
        </div>
    </div>

    <h6 class="text-dark mb-3">
        <i class="fa fa-user-md mr-1"></i> Dados da Fila
    </h6>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Autorização</div>
                <div id="autorizacao_beneficiario"><?= $dados->autorizacao ?></div>
                <div id="autorizacao_agendado"></div>
                <input type="hidden" name="autorizacao" id="autorizacao" value="<?= $dados->autorizacao ?>">
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Solicitação</div>
                <div id="solicitacao_beneficiario"><?= $data_solicitacao_formatada ?></div>
                <div id="solicitacao_agendado"></div>
                <input type="hidden" name="solicitacao" id="solicitacao" value="<?= $dados->solicitacao ?>">
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Situação</div>
                <div id="situacao_beneficiario"><?= $dados->situacao ?></div>
                <div id="situacao_agendado"></div>
                <input type="hidden" name="situacao_original" value="<?= $dados->situacao ?>">
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Justificativa</div>
                <div id="justificativa_beneficiario"><?= $dados->justificativa ?></div>
                <div id="justificativa_agendado"></div>
                <input type="hidden" name="justificativa" value="<?= $dados->justificativa ?>">
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">Descrição</div>
                <div id="justificativa_beneficiario"><?= $dados->justificativa ?></div>
                <div id="descricao_agendado"></div>
                <input type="hidden" name="justificativa" value="<?= $dados->justificativa ?>">
            </div>
        </div>
    </div>

    <h6 class="text-dark mb-3 mt-2">
        <i class="fa fa-user-md mr-1"></i> Dados do Atendimento
    </h6>

    <!-- ATENDIMENTO -->
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">MÉDICO PERITO</div>
                <select id="medico_perito" name="medico_perito" class="form-control form-control-sm" required>
                    <option value="">Selecione</option>
                </select>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">CONFIRMAÇÃO DO
                    BENEFICIÁRIO</div>
                <select class="form-control form-control-sm" name="situacao_atendimento" id="situacao_atendimento">
                    <option value="">Selecione</option>
                    <option value="CONFIRMADO">CONFIRMADO</option>
                    <option value="DESMARCADO">DESMARCADO</option>
                    <option value="REANÁLISE">REANÁLISE</option>
                    <option value="SISTEMA">SISTEMA</option>
                </select>

            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="border rounded p-2 bg-light">
                <div class="small text-dark text-uppercase font-weight-bold">PRESENÇA</div>
                <select class="form-control form-control-sm" name="atualizado" id="atualizado"
                    onchange="escondeResultado(this.value)">
                    <option value="">Selecione</option>
                    <option value="ANALISE VIA SISTEMA">ANALISE VIA SISTEMA</option>
                    <option value="COMPARECEU">COMPARECEU</option>
                    <option value="NAO COMPARECEU">NÃO COMPARECEU</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="border rounded p-2 bg-light d-none" id="resultado_container">
                <div class="small text-dark text-uppercase font-weight-bold">Resultado</div>
                <select id="resultado" name="resultado" class="form-control form-control-sm">
                    <option value="NAO COMPARECEU">Selecione</option>
                    <option value="AUTORIZADA">AUTORIZADA</option>
                    <option value="PARCIALMENTE AUTORIZADA">PARCIALMENTE AUTORIZADA</option>
                    <option value="NAO AUTORIZADA">NÃO AUTORIZADA</option>
                </select>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <div class="modal-footer  d-flex">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="btn_cancela">
            <i class="fa fa-times mr-1"></i> Cancelar
        </button>

        <button type="button" class="btn btn-danger btn-sm" id="btn_desmarca" onclick="chamaModalDescarmar()">
            <i class="fa fa-calendar-times mr-1"></i> Desmarcar
        </button>

        <button type="button" class="btn btn-warning btn-sm" id="btn_reagendar" onclick="reagendar('<?= $hoje ?>')">
            <i class="fa fa-calendar mr-1"></i> Reagendar
        </button>

        <button type="submit" class="btn btn-success btn-sm" id="btn_confirmar">
            <i class="fa fa-check mr-1"></i> Confirmar
        </button>

    </div>

</form>