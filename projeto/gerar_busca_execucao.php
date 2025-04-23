<?php
$mod = 14;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário em várias etapas</title>
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
    <script type="text/javascript" class="init"></script>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './top_bar.php' ?>
            <div id="content">
                <div class="d-flex justify-content-center flex-wrap">
                    <div class="card mb-4 border-primay" style="width: 100%; max-width: 45%; margin-right: 25px;">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width: 100%;">
                            <div class="col-sm ml-0" style="max-width:50px;">
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Formulário</span>
                            </div>
                        </div>
                        <?php include ('./form_busca_execucao.php')?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>






































<!-- <body>
    <form id="multiStepForm">
        <div class="step active">
            <h2>Passo 1</h2>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="button" onclick="nextStep()">Próximo</button>
        </div>
        <div class="step">
            <h2>Passo 2</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="button" onclick="nextStep()">Próximo</button>
        </div>
        <div class="step">
            <h2>Passo 3</h2>
            <label for="address">Endereço:</label>
            <input type="text" id="address" name="address" required>
            <button type="submit">Enviar</button>
        </div>
    </form> -->

<!-- <script>
        let currentStep = 0;

        function nextStep() {
            const steps = document.querySelectorAll('.step');
            steps[currentStep].classList.remove('active');
            currentStep++;
            if (currentStep < steps.length) {
                steps[currentStep].classList.add('active');
            }
        }
    </script> -->
</body>

</html>