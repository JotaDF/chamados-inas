<?php
$mod = 22;
include('./verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiários</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" class="init">
        var medico = [];
        <?php
        include("./actions/ManterMedicoPerito.php");
        $manterMedicoPerito = new ManterMedicoPerito();
        $listaMedico = $manterMedicoPerito->listar();
        foreach ($listaMedico as $obj) {
            ?>item = { id: "<?= $obj->id ?>", nome: "<?= $obj->nome ?>" };
            medico.push(item);
            <?php
        }
        ?>

        function proximoDia(data) {
            $.ajax({
                url: "obter_fila_pericia_eco.php",
                type: "GET",
                data: { data: data },
                dataType: "json",
                success: function (dados) {
                    preencherAgenda(dados);
                    console.log(dados);
                    const dataKey = dados.data_atual;
                    const agendados = dados.horarios_agendados[dataKey] || [];
                    const proximoFormatado = formatarDataISO(dados.proximo);
                    $("#dataProximo").text(proximoFormatado);
                    $("#dataAgendada").val(dados.data_atual);
                    atualizarBotoes(dados);
                    atualizarDiaAtual(dados);
                    atualizaDiaSemana(dados);
                    atualizarHorariosDisponiveis(dados);
                    carregaMedico(0);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX ERROR:", status, error);
                    console.log("RESPONSE TEXT:", xhr.responseText);
                    alert("Erro ao carregar dados (ver console).");
                }

            });
        }
        function preencherAgenda(dados) {
            const agenda = $("#agenda");
            agenda.empty();

            dados.agenda.forEach(function (data) {
                agenda.append(`
            <a class="dropdown-item" href="#" onclick="proximoDia('${data}')">
                ${formatarDataISO(data)}
            </a>
        `);
            });
        }

        function agendar(hora) {
            limpaModalAgendado();
            mostraInfoBeneficiario(); // <-- ESSENCIAL
            $("#texto_modal").html("<b>Deseja agendar o horário: " + hora + " ?</b>");
            $("#horaSelecionada").text(hora);
            $("#horaAgendada").val(hora);

            $('#confirm').modal('show');
        }

        function atualizarBotoes(dados) {
            $("#btnAnterior").attr("onclick", "proximoDia('" + dados.anterior + "')");
            $("#btnProximo").attr("onclick", "proximoDia('" + dados.proximo + "')");
        }

        function atualizarDiaAtual(dados) {
            const proximoFormatado = formatarDataISO(dados.data_atual);
            $("#diaAtual").text("Dia atual: " + proximoFormatado);
        }

        function atualizaDiaSemana(dados) {
            const dias = {
                Monday: "Segunda-feira",
                Tuesday: "Terça-feira",
                Wednesday: "Quarta-feira",
                Thursday: "Quinta-feira",
                Friday: "Sexta-feira",
                Saturday: "Sábado",
                Sunday: "Domingo"
            };

            document.getElementById("diaSemana").textContent = dias[dados.dia_semana];
        }

        function atualizarHorariosDisponiveis(dados) {
            const container = $("#lista_disponiveis");
            container.empty();

            const dataKey = dados.data_atual;

            // Agora horários agendados é um OBJETO
            const agendadosObj = dados.horarios_agendados[dataKey] || {};

            // Pegamos só as horas (chaves)
            const horasAgendadas = Object.keys(agendadosObj);

            // Junta disponíveis + agendados
            const todosHorarios = Array.from(
                new Set([...dados.horarios_disponiveis, ...horasAgendadas])
            ).sort();

            // Percorrer e montar botões
            todosHorarios.forEach((hora) => {
                const isAgendado = agendadosObj.hasOwnProperty(hora);
                const nome = isAgendado ? agendadosObj[hora].nome : "";

                const onclick = isAgendado
                    ? `getDadosAgendados('${dataKey}','${hora}')`
                    : `agendar('${hora}')`;

                const class_btn = isAgendado
                    ? "btn-danger border border-dark"
                    : "btn-light border-dark";

                const disabled = isAgendado
                    ? ""
                    : "disabled"

                container.append(`
            <div class="col-6 col-md-3 mb-2">
                <button
                    class="btn ${class_btn} w-100 py-2 font-weight-bold"
                    ${disabled}
                    onclick="${onclick}">
                    ${hora}  ${isAgendado ? " | " + formatarNome(nome) : " | DISPONÍVEL"}
                </button>
            </div>
        `);
            });
        }
        const nomeCompleto = isAgendado ? agendadosObj[hora].nome : "";

        function formatarNome(nome) {
            if (!nome) return "";
            const partes = nome.trim().split(/\s+/); // divide por qualquer quantidade de espaços

            if (partes.length >= 2) {
                return `${partes[0]} ${partes[1]}`;
            }

            // se só tiver um nome, retorna como está
            return partes[0];
        }

        const nome = formatarNome(nomeCompleto);


        function getUrlParam(nome) {
            const params = new URLSearchParams(window.location.search);
            return params.get(nome);
        }

        function formatarDataISO(data) {
            if (!data) return "";

            // "2025-11-18 14:42:55"
            let [dataParte] = data.split(" "); // pega só "2025-11-18"

            let [ano, mes, dia] = dataParte.split("-");

            return `${dia}/${mes}/${ano}`; // "18/11/2025"
        }

        function carregaMedico(id_atual) {
            var html = '<option value=""> Selecione um médico </option>';
            for (var i = 0; i < medico.length; i++) {
                var option = medico[i];
                var selected = "";
                if (id_atual > 0) {
                    if (option.id == id_atual) {
                        selected = "selected";
                    } else {
                        selected = "";
                    }
                }
                html += '<option value="' + option.id + '" ' + selected + '>' + option.nome + '</option>';
            }
            $('#medico_perito').html(html);
        }

        function getDadosAgendados(data, hora) {
            $.ajax({
                url: "obter_dados_beneficiario.php",
                type: "GET",
                data: { data_agendada: data, hora_agendada: hora },
                dataType: "json",
                success: function (dados) {
                    geraModalAgendado(dados, data, hora);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX ERROR:", status, error);
                    console.log("RESPONSE TEXT:", xhr.responseText);
                    alert("Erro ao carregar dados (ver console).");
                }

            });

        }
        function geraModalAgendado(dados, data, hora) {
            $("#texto_modal").html("<b>Horário agendado às: " + dados.hora_agendada + "</b>");
            let descricoes = dados.descricao.split(";");
            let telefones = dados.telefone.split(';').map(t => mascaraTelefone(t.trim())).join(' / ');
            ocultaInfoBeneficiario();
            $('#id_fila').val(dados.fila);
            $('#id').val(dados.id);
            $('#id_agendamento').val(dados.id);
            $('#nome_agendado').html(dados.nome);
            $('#cpf_agendado').html(dados.cpf);
            $('#situacao_agendado').html(dados.situacao);
            $('#solicitacao_agendado').html(formatarDataISO(dados.data_solicitacao));
            $('#descricao_agendado').html(descricoes.join('<br>'));
            $('#justificativa_agendado').html(dados.justificativa);
            $('#autorizacao_agendado').html(dados.autorizacao);
            $('#telefone_agendado').html(telefones);
            $('#horaSelecionada').text(dados.hora_agendada);
            $('#titulo_modal').removeClass('d-none').html("<i class='fa fa-calendar-check mr-2'></i>Dados do Agendamento");
            $('#btn_cancela').html("<i class='fa fa-times mr-1'></i>Fechar");
            $('#confirm').modal('show');
        }

        function ocultaInfoBeneficiario() {
            $('#nome_beneficiario').addClass('d-none');
            $('#cpf_beneficiario').addClass('d-none');
            $('#situacao_beneficiario').addClass('d-none');
            $('#descricao_beneficiario').addClass('d-none');
            $('#justificativa_beneficiario').addClass('d-none');
            $('#telefone_beneficiario').addClass('d-none');
        }

        function mostraInfoBeneficiario() {
            $('#titulo_modal').removeClass('d-none').html("<i class='fa fa-calendar-check mr-2'></i>Dados do Agendamento");
            $('#nome_beneficiario').removeClass('d-none');
            $('#cpf_beneficiario').removeClass('d-none');
            $('#situacao_beneficiario').removeClass('d-none');
            $('#descricao_beneficiario').removeClass('d-none');
            $('#justificativa_beneficiario').removeClass('d-none');
            $('#telefone_beneficiario').removeClass('d-none');
        }

        function limpaModalAgendado() {
            $("#texto_modal").html("");
            $('#nome_agendado').html("");
            $('#cpf_agendado').html("");
            $('#situacao_agendado').html("");
            $('#descricao_agendado').html("");
            $('#justificativa_agendado').html("");
            $('#telefone_agendado').html("");
            $('#horaSelecionada').text("");
        }
        function mascaraTelefone(tel) {
            tel = tel.replace(/\D/g, "");
            if (tel.length <= 10) {
                return tel.replace(/(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
            } else {
                return tel.replace(/(\d{2})(\d{5})(\d{0,4})/, "($1) $2-$3");
            }
        }
    </script>
    <style>
        body {
            font-size: small;
        }

        .dropdown-scroll {
            max-height: 200px;
            /* altura visível */
            overflow-y: auto;
            /* ativa scroll vertical */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_atendimento_pericia.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './top_bar.php'; ?>
                <?php
                $descricoes = explode(";", $dados->descricao);
                $hoje = $_GET['data'] ?? date('Y-m-d');
                ?>
                <div>
                    <div class="container-fluid">
                        <div class="card shadow-sm mt-4 mb-3 border border-primary">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-calendar fa-2x text-white"></i>
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">Agendamentos</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center px-3"
                                                id="btnAnterior" onclick="proximoDia('<?= $hoje ?>')">
                                                <i class="fa fa-chevron-left mr-2"></i> Anterior
                                            </button>
                                        </div>
                                        <script>
                                            window.onload = function () {
                                                const dataUrl = getUrlParam("data");

                                                if (dataUrl) {
                                                    proximoDia(dataUrl);
                                                    atualizaDiaSemana({ dia_semana: new Date(dataUrl).toLocaleDateString("en-US", { weekday: 'long' }) });
                                                }
                                                proximoDia("<?= $hoje ?>");
                                                atualizaDiaSemana("<?= $hoje ?>");
                                            };
                                        </script>
                                        <div class="col-md text-center">
                                            <div class="px-4 py-2 bg-light rounded shadow-sm d-inline-block">
                                                <h5 class="mb-0 text-primary fw-bold">
                                                    <i class="fa fa-calendar-day mr-1"></i>
                                                    <span id="diaAtual"></span>
                                                </h5>
                                                <small class="text-muted d-block" id="diaSemana">
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center px-3"
                                                id="btnProximo" onclick="proximoDia()">
                                                Próximo <i class="fa fa-chevron-right ml-2"></i>
                                                <span id="dataProximo" class="badge badge-primary ml-2"></span>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-success btn-sm d-flex align-items-center px-3"
                                                onclick="proximoDia('<?= $hoje ?>')">
                                                <i class="fa fa-undo mr-2"></i> Hoje
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle px-3"
                                                    id="dropdownDatas" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Selecionar data
                                                </button>
                                                <div class="dropdown-menu dropdown-scroll" id="agenda"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- Horários Disponíveis -->
                                <h5 class="text-dark">Horários</h5>
                                <div id="lista_disponiveis" class="row mt-2">
                                    <!-- Preenchido pelo AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirm" tabindex="-1">
            <div class="modal-dialog modal-lg"> <!-- modal maior para caber os dados -->
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
                            <h6 id="texto_modal"><b>Deseja agendar o horário: </b><span
                                    class="text-primary font-weight-bold" id="horaSelecionada"></span>?</h6>

                        </div>
                        <hr>
                        <!-- Dados do paciente em mini-cards -->
                        <h6 class="text-secondary mb-3">
                            <i class="fa fa-user mr-1"></i> Dados do Beneficiário
                        </h6>

                        <form action="executar_atendimento_pericia.php" method="POST" id="form_atendimento">
                            <input type="hidden" name="id_usuario" value="<?= $usuario_logado->id ?>">
                            <input type="hidden" name="data_agendada" id="dataAgendada">
                            <input type="hidden" name="hora_agendada" id="horaAgendada">
                            <input type="hidden" name="id_fila" id="id_fila">
                            <input type="hidden" name="id" id="id">

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
                                        <input type="hidden" name="telefone" id="telefone"
                                            value="<?= $dados->telefone ?>">
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
                                        <select id="medico_perito" name="medico_perito"
                                            class="form-control form-control-sm" required>
                                            <option value="">Selecione</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-2 bg-light">
                                        <div class="small text-dark text-uppercase font-weight-bold">CONFIRMAÇÃO DO
                                            BENEFICIÁRIO</div>
                                        <select class="form-control form-control-sm" name="situacao_atendimento"
                                            id="situacao_atendimento">
                                            <option value="">Selecione</option>
                                            <option value="REANÁLISE">REANÁLISE</option>
                                            <option value="SISTEMA">SISTEMA</option>
                                            <option value="CONFIRMADO">CONFIRMADO</option>
                                            <option value="DESMARCADO">DESMARCADO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-2 bg-light">
                                        <div class="small text-dark text-uppercase font-weight-bold">PRESENÇA</div>
                                        <select class="form-control form-control-sm" name="atualizado" id="atualizado">
                                            <option value="">Selecione</option>
                                            <option value="ANALISE VIA SISTEMA">ANALISE VIA SISTEMA</option>
                                            <option value="COMPARECEU">COMPARECEU</option>
                                            <option value="NÃO COMPARECEU">NÃO COMPARECEU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-2 bg-light">
                                        <div class="small text-dark text-uppercase font-weight-bold">Resultado</div>
                                        <select id="resultado" name="resultado" class="form-control form-control-sm">
                                            <option value="">Selecione</option>
                                            <option value="AUTORIZADA">AUTORIZADA</option>
                                            <option value="PARCIALMENTE AUTORIZADA">PARCIALMENTE AUTORIZADA</option>
                                            <option value="NÃO AUTORIZADA">NÃO AUTORIZADA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- FOOTER -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" data-dismiss="modal" id="btn_cancela">
                                    <i class="fa fa-times mr-1"></i> Cancelar
                                </button>

                                <button type="submit" class="btn btn-success btn-sm" id="btn_confirma">
                                    <i class="fa fa-check mr-1"></i> Confirmar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
</body>

</html>