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
                    atualizaDiaAtual(dados);
                    atualizaDiaSemana(dados)
                    atualizarHorariosDisponiveis(dados);
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

        function agendar(hora, id_atendimento) {
            limpaModalAgendado();
            mostraInfoBeneficiario();
            $("#texto_modal").html("<b>Deseja agendar o horário: " + hora + " ?</b>");
            if (id_atendimento != "") {
                $("#texto_modal").html("<b>Deseja reagendar para o horário: " + hora + " ?</b>");
            }
            $("#horaSelecionada").text(hora);
            $("#horaAgendada").val(hora);

            $('#confirm').modal('show');
        }

        function atualizarBotoes(dados) {
            $("#btnAnterior").attr("onclick", "proximoDia('" + dados.anterior + "')");
            $("#btnProximo").attr("onclick", "proximoDia('" + dados.proximo + "')");
        }

        function atualizaDiaAtual(dados) {
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

        function verificaAtendimento() {

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
            let id_atendimento = $('#id_atendimento').val();
            // Percorrer e montar botões
            todosHorarios.forEach((hora) => {
                const isAgendado = agendadosObj.hasOwnProperty(hora);
                const nome = isAgendado ? agendadosObj[hora].nome : "";

                const icon = dados.resultado != null
                    ? "fa-check"
                    : ""
                const onclick = isAgendado
                    ? `getDadosAgendados('${dataKey}','${hora}')`
                    : `agendar('${hora}', '${id_atendimento}')`;

                const class_btn = isAgendado
                    ? "btn-danger border border-dark"
                    : "btn-light border-dark";

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

        function getDadosAgendados(data, hora) {
            $.ajax({
                url: "obter_dados_beneficiario.php",
                type: "GET",
                data: { data_agendada: data, hora_agendada: hora },
                dataType: "json",
                success: function (dados) {

                    geraModalAgendado(dados);
                },
                error: function (xhr, status, error) {
                    console.log("AJAX ERROR:", status, error);
                    console.log("RESPONSE TEXT:", xhr.responseText);
                    alert("Erro ao carregar dados (ver console).");
                }

            });
        }

        function geraModalAgendado(dados) {
            console.log(dados)
            $("#texto_modal").html("<b>Horário agendado às: " + dados.hora_agendada + "</b>");
            ocultaInfoBeneficiario()
            $('#nome_agendado').html(dados.nome);
            $('#titulo_modal').removeClass('d-none').html("<i class='fa fa-calendar-check mr-2'></i>Dados do Agendamento");
            $('#cpf_agendado').html(dados.cpf);
            $('#situacao_agendado').html(dados.situacao);
            $('#descricao_agendado').html(dados.descricao);
            $('#autorizacao_agendado').html(dados.autorizacao);
            $('#justificativa_agendado').html(dados.justificativa);
            $('#telefone_agendado').html(dados.telefone);
            $('#horaSelecionada').text(dados.hora_agendada);
            $('#btn_confirma').addClass('d-none');
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
            $('#btn_confirma').removeClass('d-none');
            $('#btn_cancela').html("<i class='fa fa-times mr-1'></i> Cancelar");
        }

        function resetModal() {
            // mostra campos de beneficiário
            mostraInfoBeneficiario();

            // limpa título
            $('#titulo_modal').removeClass('d-none').html("");

            // limpa textos
            $("#texto_modal").html("");

            // limpa dados agendados
            $('#nome_agendado, #cpf_agendado, #situacao_agendado, #descricao_agendado, #autorizacao_agendado, #justificativa_agendado, #telefone_agendado').html("");

            // restaura botões
            $('#btn_confirma').removeClass('d-none');
            $('#btn_cancela').html("<i class='fa fa-times mr-1'></i> Cancelar");
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

                $hoje = $_GET['data'] ?? date('Y-m-d');
                $id_fila = $_GET['id_fila'];
                $id_atendimento = $_GET['id_atendimento'] ?? null;
                
                $dados = $manterFilaPericiaEco->getFilaPorId($id_fila);
                $periodoDatas = $manterFilaPericiaEco->getPeriodoDatas(new DateTime());
                $agenda = $manterFilaPericiaEco->criaAgenda($periodoDatas, $periodoHoras);

                $data_solicitacao_formatada = date('d/m/Y', strtotime($dados->data_solicitacao));
                $descricoes = explode(";", $dados->descricao);
                $texto_agendamento = $id_atendimento !== null ? "reagendar" : "agendar";

                ?>
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
                <div class="container mt-4">
                    <div>
                        <div class="card shadow-sm mt-3 border border-primary">
                            <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width:100%">
                                <div class="col-sm ml-0" style="max-width:50px;">
                                    <i class="fa fa-info-circle fa-2x text-white"></i>
                                </div>
                                <div class="col mb-0">
                                    <span style="align:left;" class="h5 m-0 font-weight text-white">
                                        <p id="detalhes_fila">Detalhes da
                                            Fila</pp>
                                </div>
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


                                        <!-- Centro: Data atual -->
                                        <?php include('./agenda_navegacao.php') ?>

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
            <?php include('./form_agendamento_pericia.php') ?>
        </div>
    </div>



</body>