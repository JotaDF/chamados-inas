<?php
$mod = 22;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico Perícia</title>
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
                include_once('actions/ManterAtendimentoPericia.php');
                include_once('actions/ManterBeneficiario.php');
                $manterAtendimentoPericia = new ManterAtendimentoPericia();
                $manterBeneficiario = new ManterBeneficiario();
                $cpf_beneficiario = $_GET['cpf'];
                $beneficiario = $manterBeneficiario->getBeneficiarioPorCpf($cpf_beneficiario);
                $total_atendimentos = $manterAtendimentoPericia->getTotalAtendimentoPorBeneficiario($cpf_beneficiario);
                $total_fila = $manterAtendimentoPericia->getTotalFilaBeneficiario($cpf_beneficiario);
                $atendimentos = $manterAtendimentoPericia->getAtendimentoPorBeneficiario($cpf_beneficiario);
                $fila_beneficario = $manterAtendimentoPericia->listaFilaPorCpf($cpf_beneficiario);
                ?>
                <div class="container-fluid">
                    <div class="card mb-4 border-0 shadow-sm rounded-3 bg-gradient-primary">
                        <div class="card-body text-white py-4">

                            <h4 class="fw-bold mb-0 d-flex align-items-center">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Beneficiário: <?= $beneficiario->nome ?>
                            </h4>

                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <?php if (empty($total_atendimentos) && empty($total_fila)) { ?>
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm p-4 text-center"
                                        style="background: linear-gradient(135deg, #ffffff, #f3f6f9); border-radius: 16px;">
                                        <div class="card-body d-flex flex-column align-items-center">
                                            <h5 class="fw-bold text-primary mb-2">
                                                Nenhuma fila ou atendimento encontrados
                                            </h5>

                                            <p class="text-muted mb-3" style="max-width: 250px;">
                                                Não há registros de atendimento ou fila para este beneficiário.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-12 col-md-6">
                                <?php if (empty($total_atendimentos) && $total_fila > 0) { ?>

                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 text-center"
                                            style="background: linear-gradient(135deg, #ffffff, #f3f6f9); border-radius: 16px;">
                                            <div class="card-body d-flex flex-column align-items-center">
                                                <h5 class="fw-bold text-primary mb-2">
                                                    Nenhum atendimento encontrado
                                                </h5>

                                                <p class="text-muted mb-3" style="max-width: 250px;">
                                                    Não há registros de atendimento para este beneficiário.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($total_atendimentos > 0) { ?>
                                    <?php foreach ($atendimentos as $atendimento) {
                                        $data_agendada = date('d/m/Y', strtotime($atendimento->data_agendada));
                                        $data_hora_agendada = $data_agendada . " " . $atendimento->hora_agendada;
                                        ?>
                                        <div class="card shadow-sm border-0 rounded-3 mb-3">
                                            <div class="card-header bg-gradient-primary text-white py-2">
                                                <i class="bi bi-file-earmark-text me-2"></i>
                                                <span class="fw-semibold">Atendimento</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-4">
                                                        <div class="text-uppercase fw-bold">Guia</div>
                                                        <div class="fw-semibold"><b><?= $atendimento->guia ?></b></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-uppercase fw-bold">Data e Hora
                                                            Agendada</div>
                                                        <div class="fw-semibold"><b><?= $data_hora_agendada ?></b></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="text-uppercase fw-bold">Situação</div>
                                                        <div class="fw-semibold"><b><?= $atendimento->situacao ?></b></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-bold">Procedimento</div>
                                                        <div class="fw-semibold p-2 border rounded bg-light">
                                                            <b><?= $atendimento->procedimento ?></b>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase fw-bold">Resultado</div>
                                                        <div class="fw-semibold p-2 border rounded bg-light">
                                                            <b><?= $atendimento->resultado ?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php }
                                } ?>
                            </div>

                            <!-- COLUNA 2: FILA -->
                            <div class="col-12 col-md-6">
                                <?php if (empty($total_fila) && $total_atendimentos > 0) {
                                    ?>
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm p-4 text-center"
                                            style="background: linear-gradient(135deg, #ffffff, #f3f6f9); border-radius: 16px;">
                                            <div class="card-body d-flex flex-column align-items-center">
                                                <h5 class="fw-bold text-primary mb-2">
                                                    Nenhuma fila encontrada
                                                </h5>

                                                <p class="text-muted mb-3" style="max-width: 250px;">
                                                    Não há registros de fila para este beneficiário.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                if ($total_fila > 0) { ?>
                                    <?php foreach ($fila_beneficario as $fila) {
                                        $data = explode(' ', $fila->data_solicitacao)[0] ?? '';
                                        $data_solicitacao = date('d/m/Y', strtotime($data));
                                        ?>

                                        <div class="card shadow-sm border-0 rounded-3 mb-3">
                                            <div class="card-header bg-gradient-primary text-white py-2">
                                                <i class="bi bi-file-earmark-text me-2"></i>
                                                <span class="fw-semibold">Fila</span>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="text-uppercase text-dark">Guia</div>
                                                        <div class="fw-semibold"><b><?= $fila->id_guia ?></b></div>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <div class="text-uppercase text-dark">Data Solicitação</div>
                                                        <div class="fw-semibold"><b><?= $data_solicitacao ?></b></div>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <div class="text-uppercase text-dark">Autorização</div>
                                                        <div class="fw-semibold"><b><?= $fila->autorizacao ?></b></div>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <div class="text-uppercase text-dark mb-1">Descrição</div>
                                                        <div class="fw-semibold"><b><?= $fila->descricao ?></b></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase text-dark mb-1">Situação</div>
                                                        <div class="fw-semibold"><b><?= $fila->situacao ?></b></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-uppercase text-dark mb-1">Justificativa</div>
                                                        <div class="fw-semibold"><b><?= $fila->justificativa ?></b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <?php include('./rodape.php') ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    </div>
</body>

</html>