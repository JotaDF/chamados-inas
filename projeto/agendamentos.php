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
                    atualizarHorariosDisponiveis(agendados, dados.horarios_disponiveis, dados.data_atual);
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

        function atualizarHorariosDisponiveis(horarios_agendados, horarios_disponiveis, data) {
            const container = $("#lista_disponiveis");
            container.empty();
            const todosHorarios = Array.from(
                new Set([...horarios_disponiveis, ...horarios_agendados])
            ).sort();

            const agendadosSet = new Set(horarios_agendados);

            todosHorarios.forEach((hora) => {
                const isAgendado = agendadosSet.has(hora);

                const onclick = isAgendado
                    ? `getDadosAgendados('${data}','${hora}')`
                    : `agendar('${hora}')`;

                const class_btn = isAgendado
                    ? 'btn-danger border border-dark'
                    : 'btn-light border-dark';

                container.append(`
            <div class="col-6 col-md-3 mb-2">
                <button
                    class="btn ${class_btn} w-100 py-2 font-weight-bold"
                    onclick="${onclick}">
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

        function getUrlParam(nome) {
            const params = new URLSearchParams(window.location.search);
            return params.get(nome);
        }

        function formatarDataISO(dataISO) {
            if (!dataISO) return "";
            const [ano, mes, dia] = dataISO.split("-");
            return `${dia}/${mes}/${ano}`;
        }
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
                <div>
                    <div class="container-fluid">
                        <div class="card shadow-sm mt-4 mb-3 border border-primary">
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
</body>

</html>