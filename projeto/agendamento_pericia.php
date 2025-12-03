<?php
$mod = 22;
include_once('./verifica_login.php');

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
                    atualizaDiaSemana(dados)
                    atualizarHorariosDisponiveis(agendados, dados.horarios_disponiveis);
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
            $("#horaSelecionada").text(hora); // coloca a hora dentro do modal 
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

        function atualizarHorariosDisponiveis(horarios_agendados, horarios_disponiveis) {
            const container = $("#lista_disponiveis");
            container.empty();

            // Mescla os horários e ordena
            horarios_agendados.forEach(h => {
                if (!horarios_disponiveis.includes(h)) {
                    horarios_disponiveis.push(h);
                }
            });
            horarios_disponiveis.sort();

            const agendadosSet = new Set(horarios_agendados);

            horarios_disponiveis.forEach(function (hora) {
                const isAgendado = agendadosSet.has(hora);

                container.append(`
            <div class="col-6 col-md-3 mb-2">
                <button
                    class="btn ${isAgendado ? 'btn-danger border border-dark' : 'btn-light border-dark'}  w-100 py-2 font-weight-bold"
                    onclick="agendar('${hora}')">
                    ${hora}
                </button>
            </div>
        `);
            });
        }

        function atualizarHorariosAgendados(horariosAgendados, dataAtual) {
            const container = $("#lista_agendados");
            container.empty();

            const lista = horariosAgendados[dataAtual];

            if (lista && lista.length > 0) {
                lista.forEach(function (hora) {
                    container.append(`
                <div class="col-6 col-md-3 mb-2">
                    <button 
                        class="btn btn-danger w-100 py-2 font-weight-bold"
                        onclick="agendar('${hora}')">
                        ${hora}
                    </button>
                </div>
            `);
                });

            } else {
                container.html(`
            <div class="col-12 text-muted">Nenhum horário agendado.</div>
        `);
            }
        }



        function formatarDataISO(dataISO) {
            if (!dataISO) return "";
            const [ano, mes, dia] = dataISO.split("-");
            return `${dia}/${mes}/${ano}`;
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
                include_once('actions/ManterFilaPericiaEco.php');
                include_once('actions/ManterFilaPericiaEco.php');
                $manterFilaPericiaEco = new ManterFilaPericiaEco();
                $manterFilaPericiaEco = new ManterFilaPericiaEco();
                $datas = $manterFilaPericiaEco->getDataAgendamento();
                $hoje = date('d/m/Y');
                $datas_formatada = explode(" ", $datas_formatada);
                $data_atual = $_GET['data'] ?? date('Y-m-d');
                $id_fila = $_GET['id'];
                $dados = $manterFilaPericiaEco->getFilaPorId($id_fila);
                $periodoDatas = $manterFilaPericiaEco->getPeriodo(new DateTime());
                $periodoHoras = $manterFilaPericiaEco->getHorarios();
                $agenda = $manterFilaPericiaEco->criaAgenda($periodoDatas, $periodoHoras);
                $datas = date("Y-m-d", strtotime($data));
                $data_solicitacao_formatada = date('d/m/Y', strtotime($dados->data_solicitacao));
                $dias_para_agendamento = $manterFilaPericiaEco->getPeriodo(new DateTime());
                $soDatas = array_map(function ($dt) {
                    return $dt->format('d/m/Y');
                }, $dias_para_agendamento);
                $descricoes = explode(";", $dados->descricao);

                ?>
                <script>
                    window.onload = function () {
                        proximoDia("<?= $hoje ?>");
                    };
                </script>
                <div class="container mt-4">
                    <div>
                        <div class="card shadow-sm mt-3 border border-primary">
                            <div class="card-header bg-gradient-primary">
                                <h5 class="card-title text-white">Detalhes da Fila</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-4">
                                        <div class="text-uppercase small text-muted fw-bold">Nome</div>
                                        <div class="fw-semibold" id="id"><?= $dados->nome ?></div>
                                    </div>

                                    <div class="col-4">
                                        <div class="text-uppercase small text-muted fw-bold">CPF</div>
                                        <div class="fw-semibold" id="cpf"><?= $dados->cpf ?></div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="text-uppercase small text-muted fw-bold">Telefone</div>
                                        <div class="fw-semibold" id="id_guia"><?= $dados->telefone ?></div>
                                    </div>

                                    <div class="col-4">
                                        <div class="text-uppercase small text-muted fw-bold">Autorização</div>
                                        <div class="fw-semibold" id="autorizacao"><?= $dados->autorizacao ?></div>
                                    </div>

                                    <div class="col-4">
                                        <div class="text-uppercase small text-muted fw-bold">Data Solicitação</div>
                                        <div class="fw-semibold" id="data_solicitacao">
                                            <?= $data_solicitacao_formatada ?>
                                        </div>
                                    </div>
                                    <div class="col-4 ">
                                        <div class="text-uppercase small text-muted fw-bold">Situação</div>
                                        <div class="fw-semibold" id="situacao"><?= $dados->situacao ?></div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <div class="text-uppercase small text-muted fw-bold">justificativa</div>
                                        <div class="fw-semibold p-2 border bg-light rounded" id="justificativa">
                                            <?= $dados->justificativa ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-uppercase small text-muted fw-bold">Descrição</div>
                                        <div class="fw-semibold p-2 border bg-light rounded" id="descricao">
                                            <?php foreach ($descricoes as $descricao) {
                                                echo $descricao . "</br>";
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-4 mb-3 border border-primary">
                            <div class="card-body">
                                <div class="container-fluid">

                                    <div class="row g-2 align-items-center">

                                        <!-- Botão Anterior -->
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center px-3"
                                                id="btnAnterior" onclick="proximoDia('<?= $hoje ?>')">
                                                <i class="fa fa-chevron-left mr-2"></i> Anterior
                                            </button>
                                        </div>

                                        <!-- Centro: Data atual -->
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

                                        <!-- Botão Próximo -->
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center px-3"
                                                id="btnProximo" onclick="proximoDia()">
                                                Próximo <i class="fa fa-chevron-right ml-2"></i>
                                                <span id="dataProximo" class="badge badge-primary ml-2"></span>
                                            </button>
                                        </div>

                                        <!-- Botão Voltar hoje -->
                                        <div class="col-auto">
                                            <button
                                                class="btn btn-outline-success btn-sm d-flex align-items-center px-3"
                                                onclick="proximoDia('<?= $hoje ?>')">
                                                <i class="fa fa-undo mr-2"></i> Hoje
                                            </button>
                                        </div>

                                        <!-- Dropdown -->
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
            <?php include('./rodape.php') ?>
        </div>
    </div>
    <div class="modal fade" id="confirm" tabindex="-1">
        <div class="modal-dialog modal-lg"> <!-- modal maior para caber os dados -->
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title">
                        <i class="fa fa-calendar-check mr-2"></i>
                        Confirmar Agendamento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- Frase principal -->
                    <div class="alert alert-info text-center">
                        <h6><b>Deseja agendar o horário: </b><span class="text-primary font-weight-bold"
                                id="horaSelecionada"></span>?</h6>

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
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">Nome</div>
                                    <div class="font-weight-bold"><?= $dados->nome ?></div>
                                    <input type="hidden" name="nome" id="nome" value="<?= $dados->nome ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">CPF</div>
                                    <div class="font-weight-bold"><?= $dados->cpf ?></div>
                                    <input type="hidden" name="cpf" id="cpf" value="<?= $dados->cpf ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">Telefone</div>
                                    <div class="font-weight-bold"><?= $dados->telefone ?></div>
                                    <input type="hidden" name="telefone" id="telefone" value="<?= $dados->telefone ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">Autorização</div>
                                    <div class="font-weight-bold"><?= $dados->autorizacao ?></div>
                                    <input type="hidden" name="autorizacao" id="autorizacao"
                                        value="<?= $dados->autorizacao ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">Solicitação</div>
                                    <div class="font-weight-bold"><?= $data_solicitacao_formatada ?></div>
                                    <input type="hidden" name="solicitacao" id="solicitacao"
                                        value="<?= $dados->solicitacao ?>">
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-light">
                                    <div class="small text-muted text-uppercase">Situação</div>
                                    <div class="font-weight-bold"><?= $dados->situacao ?></div>
                                    <input type="hidden" name="situacao" id="situacao" value="<?= $dados->situacao ?>">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="border rounded p-2 bg-white">
                                    <div class="small text-muted text-uppercase">Justificativa</div>
                                    <div><?= $dados->justificativa ?></div>
                                    <input type="hidden" name="justificativa" id="justificativa"
                                        value="<?= $dados->justificativa ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="border rounded p-2 bg-white">
                                    <div class="small text-muted text-uppercase">Descrição</div>
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
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Cancelar
                    </button>

                    <button type='submit' class="btn btn-success btn-sm">
                        <i class="fa fa-check mr-1"></i> Confirmar
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>



</body>