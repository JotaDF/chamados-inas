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
                $atendimentos = $manterAtendimentoPericia->getAtendimentoPorBeneficiario($cpf_beneficiario);
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
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php
                        if ($total_atendimentos > 0) {

                            foreach ($atendimentos as $atendimento) {

                                // Formata a data
                                $data_agendada = date('d/m/Y', strtotime($atendimento->data_agendada));
                                ?>

                                <div class="col">
                                    <div class="card shadow-sm border-0 rounded-3 h-100">

                                        <!-- Cabeçalho do card -->
                                        <div class="card-header bg-gradient-primary text-white py-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-text me-2"></i>
                                                <span class="fw-semibold">Atendimento</span>
                                            </div>
                                        </div>

                                        <!-- Corpo -->
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="
                                                 text-uppercase  fw-bold">Guia</div>
                                                    <div class="fw-semibold"><b><?= $atendimento->guia ?></b></div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="
                                                 text-uppercase">Situação</div>
                                                    <div class="fw-semibold"><b><?= $atendimento->situacao ?></b></div>
                                                </div>

                                                <div class="col-12 col-md-6 ">
                                                    <div class="
                                                 text-uppercase  fw-bold">Data Agendada</div>
                                                    <div class="fw-semibold"><b><?= $data_agendada ?></b></div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="
                                                 text-uppercase  fw-bold">Hora Agendada</div>
                                                    <div class="fw-semibold"><b><?= $atendimento->hora_agendada ?></b></div>
                                                </div>

                                            </div>

                                            <!-- Procedimento -->
                                            <div class="mt-4 p-3 rounded bg-light border">
                                                <div class="text-uppercase text-primary fw-bold">Procedimento</div>
                                                <div class="mt-1"><?= $atendimento->procedimento ?></div>
                                            </div>
                                            <div class="mt-4 p-3 rounded bg-light border">
                                                <div class="text-uppercase text-primary fw-bold">Resultado</div>
                                                <div class="mt-1"><?= $atendimento->resultado ?></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        } else {
                            ?>

                            <div class="col">
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