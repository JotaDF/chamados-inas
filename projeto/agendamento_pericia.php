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
    <?php

    ?>
    <script type="text/javascript" class="init">
        function proximoDia(data) {
            $.ajax({
                url: "obter_fila_pericia_eco.php",
                type: "GET",
                data: { data: data },
                dataType: "json",
                success: function (dados) {
                    console.log(dados);
                    const proximoFormatado = formatarDataISO(dados.proximo);
                    $("#dataProximo").text(proximoFormatado);
                    atualizarBotoes(dados);
                    atualizarDiaAtual(dados);
                    const dataKey = dados.data_atual;
                    const agendados = dados.horarios_agendados[dataKey] || [];

                    atualizarHorariosDisponiveis(agendados, dados.horarios_disponiveis);
                },
                error: function () {
                    alert("Erro ao carregar dados.");
                }
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

        function atualizarHorariosDisponiveis(horarios_agendados, horarios_disponiveis) {
            const container = $("#lista_disponiveis");
            container.empty();
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
            <div class="col-3 mb-2">
                <div class="p-2 text-center border rounded font-weight-bold
                    ${isAgendado ? 'bg-danger text-white' : 'bg-light'}">
                    ${hora}
                </div>
            </div>
        `);
            });
        }
        //     horarios_disponiveis.forEach(function (hora) {
        //         container.append(`
        //         <div class="col-3 mb-2">
        //             <div class="p-2 text-center border rounded bg-light font-weight-bold">
        //                 ${hora}
        //             </div>
        //         </div>
        //     `);
        //     });
        // }
        function atualizarHorariosAgendados(horariosAgendados, dataAtual) {
            const container = $("#lista_agendados");
            container.empty();

            const lista = horariosAgendados[dataAtual];

            if (lista && lista.length > 0) {
                lista.forEach(function (hora) {
                    container.append(`
                <div class="col-3 mb-2">
                    <div class="p-2 text-center border rounded bg-danger text-white font-weight-bold">
                        ${hora}
                    </div>
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
                $manterFilaPericiaEco = new ManterFilaPericiaEco();
                $datas = $manterFilaPericiaEco->getDataAgendamento();
                $hoje = date('d/m/Y');
                $datas_formatada = explode(" ", $datas_formatada);
                $id_fila = $_GET['id'];
                $dados = $manterFilaPericiaEco->getFilaPorId($id_fila);
                $periodoDatas = $manterFilaPericiaEco->getPeriodo(new DateTime());
                $periodoHoras = $manterFilaPericiaEco->getHorarios();
                $agenda = $manterFilaPericiaEco->criaAgenda($periodoDatas, $periodoHoras);
                $datas = date("Y-m-d", strtotime($data));
                $data_solicitacao_formatada = date('d/m/Y', strtotime($dados->data_solicitacao));
                include_once('actions/ManterFilaPericiaEco.php');
                $manterFilaPericiaEco = new ManterFilaPericiaEco();
                $dias_para_agendamento = $manterFilaPericiaEco->getPeriodo(new DateTime());
                $soDatas = array_map(function ($dt) {
                    return $dt->format('d/m/Y');
                }, $dias_para_agendamento);

                ?>

                <div class="container mt-4">
                    <div>
                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Detalhes da Fila</h5>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">Nome</div>
                                        <div class="fw-semibold" id="id"><?= $dados->nome ?></div>
                                    </div>

                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">CPF</div>
                                        <div class="fw-semibold" id="cpf"><?= $dados->cpf ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">Guia</div>
                                        <div class="fw-semibold" id="id_guia"><?= $dados->id_guia ?></div>
                                    </div>

                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">Autorização</div>
                                        <div class="fw-semibold" id="autorizacao"><?= $dados->autorizacao ?></div>
                                    </div>

                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">Data Solicitação</div>
                                        <div class="fw-semibold" id="data_solicitacao">
                                            <?= $data_solicitacao_formatada ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-uppercase small text-muted fw-bold">Situação</div>
                                        <div class="fw-semibold" id="situacao"><?= $dados->situacao ?></div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-uppercase small text-muted fw-bold">justificativa</div>
                                        <div class="fw-semibold p-2 border bg-light rounded" id="justificativa">
                                            <?= $dados->justificativa ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-uppercase small text-muted fw-bold">Descrição</div>
                                        <div class="fw-semibold p-2 border bg-light rounded" id="descricao">
                                            <?= $dados->descricao ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <button class="btn btn-primary btn-sm" id="btnAnterior"
                                        onclick="proximoDia('<?= $hoje ?>')">Anterior</button>
                                    <h3 id="diaAtual">Dia atual: <?php echo $hoje; ?></h3>

                                    <button class="btn btn-primary btn-sm" id="btnProximo" onclick="proximoDia()">
                                        Próximo: <span id="dataProximo"></span>
                                    </button>
                                    <button class="btn btn-primary dropdown-toggle dropdown-small-btn" type="button"
                                        id="dropdownDatas" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Selecionar data
                                    </button>

                                    <div class="dropdown-menu dropdown-small-menu">
                                        <?php foreach ($soDatas as $data) {
                                            $dataISO = DateTime::createFromFormat('d/m/Y', $data)->format('Y-m-d');
                                            ?>
                                            <a class="dropdown-item" href="#" onclick="proximoDia('<?= $dataISO ?>')">
                                                <?= $data ?>
                                            </a>
                                        <?php } ?>
                                    </div>

                                </div>
                                <hr>

                                <!-- Horários Disponíveis -->
                                <h5 class="text-success">Horários Disponíveis</h5>
                                <div id="lista_disponiveis" class="row mt-2">
                                    <!-- Preenchido pelo AJAX -->
                                </div>

                                <div id="lista_agendados" class="row mt-2">
                                    <!-- Preenchido pelo AJAX -->
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- <h2><a href="#" id="btnAnterior" onclick="proximoDia(<?= $hoje ?>)">Anterior</a></h2> -->
                    <!-- <h3 id="diaAtual">Dia atual: <?php echo $data_atual; ?></h3> -->
                    <!-- <h2><a href="#" id="btnProximo" onclick="proximoDia('<?= $hoje ?>')">Proximo</a></h2> -->
                    <div class="container mt-4 mb-4">


                    </div>

                </div>
            </div>
            <?php include('./rodape.php') ?>
        </div>
    </div>

</body>