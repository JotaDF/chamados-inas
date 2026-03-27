<div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="titulo_modal">

                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- Frase principal -->
                    <div class="alert alert-info text-center">
                        <h6 id="texto_modal"><b>Deseja <?php echo $texto_agendamento ?> o horário: </b><span
                                class="text-primary font-weight-bold" id="horaSelecionada"></span>?</h6>
                    </div>
                    <hr>
                    <!-- Dados do paciente em mini-cards -->
                    <h6 class="text-secondary mb-3">
                        <i class="fa fa-user mr-1"></i> Dados do Beneficiário
                    </h6>

                    <form action="save_agendamento_pericia.php" method="POST">
                        <input type="hidden" name="id_usuario" value="<?= $usuario_logado->id ?>">
                        <input type="hidden" name="data_agendada" id="dataAgendada">
                        <input type="hidden" name="hora_agendada" id="horaAgendada">
                        <input type="hidden" name="id_fila" id="id_fila" value="<?= $id_fila ?>">
                        <input type="hidden" name="id_atendimento" id="id_atendimento" value="<?= $id_atendimento ?>">
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
                            <hr>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-dark text-uppercase font-weight-bold">Autorização</div>
                                    <div id="autorizacao_beneficiario"><?= $dados->autorizacao ?></div>
                                    <div id="autorizacao_agendado"></div>
                                    <input type="hidden" name="autorizacao" id="autorizacao"
                                        value="<?= $dados->autorizacao ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-dark text-uppercase font-weight-bold">Solicitação</div>
                                    <div id="solicitacao_beneficiario"><?= $data_solicitacao_formatada ?></div>
                                    <div id="solicitacao_agendado"></div>
                                    <input type="hidden" name="solicitacao" id="solicitacao"
                                        value="<?= $dados->solicitacao ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-dark text-uppercase font-weight-bold">Situação</div>
                                    <div id="situacao_beneficiario"><?= $dados->situacao ?></div>
                                    <div id="situacao_agendado"></div>
                                    <input type="hidden" name="situacao" id="situacao" value="<?= $dados->situacao ?>">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-dark text-uppercase font-weight-bold">Justificativa</div>
                                    <div id="justificativa_beneficiario"><?= $dados->justificativa ?></div>
                                    <div id="justificativa_agendado"></div>
                                    <input type="hidden" name="justificativa" id="justificativa"
                                        value="<?= $dados->justificativa ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-dark text-uppercase font-weight-bold">Descrição</div>
                                    <div>
                                        <?php foreach ($descricoes as $descricao) {
                                            echo $descricao . "<br>";
                                        } ?>
                                    </div>
                                    <input type="hidden" name="descricao" id="descricao" value="<?= $descricao ?>">
                                </div>
                            </div>
                        </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal" id="btn_cancela">
                        <i class="fa fa-times mr-1"></i> Cancelar
                    </button>

                    <button type='submit' class="btn btn-success btn-sm" id="btn_confirma">
                        <i class="fa fa-check mr-1"></i> Confirmar
                    </button>
                </div>
                </form>
            </div>