<?php
require_once('./verifica_login.php');
require_once('./actions/ManterUsuario.php');
require_once('./actions/ManterSlaRegulacao.php');
$manterSlaRegulacao = new ManterSlaRegulacao();
// var_dump($manterSlaRegulacao->getListaDiasFeriado('2025'));
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <script src="vendor/jquery-easing/jquery.easing.min.js">
        $(document).ready(function () {
            $('#folhas_ponto').DataTable()
        });

    </script>

    </script>
    <style>
        body {
            font-family: "Arial";
            font-size: 15px;
        }



        .header-governo {
            font-family: "Arial";
            font-size: 12px;
            margin-bottom: -1px;
        }

        #folha_pontos th,
        #folha_pontos td {
            border: 1px solid black !important;
        }

        #folha_pontos {
            border-collapse: collapse;
            width: 100%;
        }

        .final_semana {
            background-color: #d3d3d3;
        }

        .print-header {
            border: 1px solid black;
            border-bottom: none;
            padding: 4px;
            font-size: 18px;
            text-align: center;
        }

        .print-subheader {
            border: 1px solid black;
            border-top: none;
            padding: 4px;
            font-size: 15px;
            text-align: center;
        }

        .assinatura-box {
            border: 1px solid black;
            height: 115px;
            /* aumenta o espaço vertical */
            padding: 8px;
            /* mais respiro interno */
            display: flex;
            align-items: flex-end;
            /* texto fica embaixo, como assinatura real */
            justify-content: center;
            text-align: center;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
            /* ou page-break-after */
        }

        .card-body {
            margin-top: -1 !important;
            margin-bottom: -1 !important;
        }

        @media print {
            #header-governo {
                margin-bottom: -1px !important;
                /* cola sem sobrar espaço */
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
                font-family: "Arial";
                font-size: 15px;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .sub-header {
                margin-top: 0 !important;
            }

            .assinatura-box {
                border: 1px solid black;
                height: 130px;
                padding: 15px;
                display: flex;
                align-items: flex-end;
                justify-content: center;
                text-align: center;
                font-weight: bold;
            }

            .header-governo {
                font-family: "Arial";
                font-size: 12px;
                margin-bottom: -1px;
            }

            #folha_pontos th,
            #folha_pontos td {
                border: 1px solid black !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #folha_pontos {
                border-collapse: collapse;
                width: 100%;
            }

            .final_semana {
                background-color: #d3d3d3 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-header {
                border: 1px solid black;
                border-bottom: none;
                padding: 4px;
                font-size: 18px;
                text-align: center;
                background-color: #e9e9e9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-subheader {
                border: 1px solid black;
                border-top: none;
                padding: 4px;
                font-size: 15px;
                text-align: center;
                background-color: #e9e9e9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card-body {
                margin-top: -1 !important;
                margin-bottom: -1 !important;
            }
        }


        
    </style>
</head>

<body>
    <?php
    include_once('actions/ManterUsuario.php');
    $id_usuario = $_GET['id'];
    $nome_mes = $_GET['nome_mes'];
    $ano = $_GET['ano'];
    $ref = $nome_mes . "/" . $ano;
    $manterUsuario = new ManterUsuario;
    $usuario = $manterUsuario->getUsuarioPorId($id_usuario);
    ?>
    <div class="conteudo-principal">


        <div class="container border border-dark p-2 mt-2 text-center"
            style="max-width:96%; background-color:#d3d3d3; font-size:18px;">
            <b>GOVERNO DO DISTRITO FEDERAL<br>
                INSTITUTO DE ASSISTÊNCIA A SAÚDE DOS SERVIDORES DO DF - INAS
            </b>
        </div>

        <div class="container border border-top-0 border-dark p-2 text-center"
            style="max-width:96%; max-height: 90%; font-size:15px;">
            <b>FOLHA DE FREQUÊNCIA</b>
        </div>

        <div class="container border border-dark border-top-0 p-2"
            style="max-width: 96%; font-size:15px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
            <div class="row mb-1">
                <div class="col"><b>NOME:</b> <?= $usuario->nome ?></div>
                <div class="col"><b>REF:</b> <?= strtoupper($ref); ?></div>
                <div class="col"><b>CARGO EFETIVO:</b> <?= $usuario->cargo_efetivo ?></div>
            </div>
            <div class="row mb-1">
                <div class="col"><b>MATRÍCULA:</b> <?= $usuario->matricula ?></div>
                <div class="col"><b>CARGO EM COMISSÃO:</b> <?= strtoupper($usuario->cargo) ?></div>
                <div class="col"><b>SÍMBOLO:</b> <?= $usuario->simbolo_cargo ?></div>
            </div>
            <div class="row mb-1">
                <div class="col-7"><b>UA:</b> 001 - INAS</div>
                <div class="col-auto"><b>CARGA HORÁRIA:</b> 40H</div>
                <div class="col-auto"><b>CÓDIGO LOTAÇÃO:</b> <?= $usuario->codigo_lotacao ?></div>
                <div class="col"><b>DESC LOTAÇÃO:</b> <?= $usuario->descricao_lotacao ?></div>
            </div>

        </div>

        <div class="container border border-top-0  mt-2 mb-2 p-0 " style="max-width:96%;">
            <table id="folha_pontos" class="table-sm table-bordered dt-responsive nowrap text-center text-dark m-0">
                <thead>
                    <tr>
                        <th style="border:1px solid black;"></th>
                        <th style="border:1px solid black;" class="text-left" colspan="3"><b>Turno: MATUTINO</b></th>
                        <th style="border:1px solid black;" class="text-left" colspan="3"><b>Turno: VESPERTINO</b></th>
                        <th style="border:1px solid black;"></th>
                    </tr>
                    <tr>
                        <th style="background-color:#d3d3d3; border:1px solid black;"><b>Dia</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black;"><b>Assinatura do Servidor</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black;  cursor: pointer; width:100px;"
                            title="Remover Horario" onclick="toggleColunaHorario(2)"><b>Entrada</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black;  cursor: pointer; width:100px;"
                            title="Remover Horario" onclick="toggleColunaHorario(3)"><b>Saída</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black;"><b>Assinatura do Servidor</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black; cursor: pointer; width:100px;"
                            title="Remover Horario" onclick="toggleColunaHorario(4)"><b>Entrada</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black; cursor: pointer; width:100px;"
                            title="Remover Horario" onclick="toggleColunaHorario(5)"><b>Saída</b></th>
                        <th style="background-color:#d3d3d3; border:1px solid black; width:100px;"><b>CÓD</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('gerar_folha_ponto.php'); ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="container mb-6" style="width: 96%;">
        <div class="row text-center" style="gap: 20px;">
            <div class="col assinatura-box">
                ASSINATURA E CARIMBO DO CHEFE IMEDIATO
                &nbsp;&nbsp;&nbsp;
                <br><br><br><br><br>
            </div>
            <div class="col assinatura-box">
                <br><br><br><br><br><br>
                ASSINATURA E CARIMBO DO SUPERIOR HIERÁRQUICO
                &nbsp;&nbsp;&nbsp;
                <br><br><br><br><br>
            </div>
        </div>
    </div>
    </div>

    <div class="container border border-dark border-bottom-0 p-2 mt-5 text-center page-break"
        style="max-width:96%; background-color:#d3d3d3; font-size:24px;">
        <b>GOVERNO DO DISTRITO FEDERAL<br>
        </b>
    </div>
    <div class="container border border-bottom-0 border-dark p-2 text-center"
        style="max-width:96%; max-height: 90%; font-size:15px;">
        <div class="row mb-1">
            <div class="col"><b>MATRÍCULA:</b> <?= $usuario->matricula ?></div>
            <div class="col"><b>UA:</b> 001 </div>
            <div class="col-8"><b>LOTAÇÃO:</b> <?= $usuario->descricao_lotacao ?></div>
        </div>

    </div>
    <div class="container border border-dark p-0 " style="max-width:96%;">
        <div class="col text-center" style="font-size: 18px"><b>TABELA DE CODIFICAÇÃO</b></div>
        <br>
        <div class="col text-start mb-1"><b>NA COLUNA RELATIVA AO CÓDIGO SERÃO ANOTADAS, DE ACORDO COM A CODIFICAÇÃO
                ABAIXO, AS CORRÊNCIAS DO MÊS,
                RELATIVAS AO SERVIDOR.
            </b></div>
    </div>
    <div class="container border border-dark border-top-0 p-0" style="max-width:96%;">
        <div class="mb-2"><b> &nbsp;&nbsp;OBSERVAÇÕES:</b></div class="mb-2">
        <?php
        for ($i = 0; $i <= 14; $i++) {
            echo "<div style='height: 1px; background-color: #000; margin-bottom: 35px;'></div>";
        }
        ?>
    </div>
    <div class="container border border-dark  border-top-0 p-2 text-center"
        style="max-width:96%; background-color:#d3d3d3; font-size:18px;">
        <b>CÓDIGOS<br>
        </b>
    </div>
    <div class="container border border-top-0 border-dark p-2" style="max-width:96%; max-height: 90%; font-size:15px; ">

        <div class="row text-start">
            <div class="col-12"><b>118 - Exame Médico Preventivo ou Periódico</b></div>
            <div class="col-12"><b>119 - Falta injustificada </b></div>
            <div class="col-12"><b>205 - Licença motivo doença família (efetivo)</b></div>
            <div class="col-12"><b>207 - Licença maternidade </b></div>
            <div class="col-12"><b>211 - Licença adoção (07) dias consecutivos inclusive o dia do acontecimento</b>
            </div>
            <div class="col-12"><b>219 - Abono </b></div>
            <div class="col-12"><b>258 - Recesso</b></div>
            <div class="col-12"><b>289 - Licença paternidade 07 dias consecutivos inclusive o dia do nascimento</b>
            </div>
            <div class="col-12"><b>310 - Afastamento doação de sangue</b></div>
            <div class="col-12"><b>313 - Afastamento falecimento família (08 dias)</b></div>
            <div class="col-12"><b>314 - Afastamento júri serviço obrigatório</b></div>
            <div class="col-12"><b>317 - Afastamento para casamento 08 dias</b></div>
            <div class="col-12"><b>318 - Afastamento para participação em treinamento/Curso</b></div>
            <div class="col-12"><b>339 - Prorrogação Licença paternidade (23 dias)</b></div>
            <div class="col-12"><b>340 - Atestado de Comparecimento </b></div>
            <div class="col-12"><b>345 - Atestado de até 3 dias</b></div>
            <div class="col-12"><b>594 - Férias</b></div>
            <br><br>
        </div>

    </div>
    <div class="text-center mb-4">
        <b>SISTEMA ÚNICO DE GESTÃO DE RECURSOS HUMANOS - SIGRH</b>
    </div>

    </div>
    <div class="container text-center" style="max-width:96%; background-color:#e9e9e9; font-size:15px;">
        INSTIUTO DE ASSISTÊNCIA A SAÚDE DOS SERVIDORES DO DF - INAS
        <br>
        <b>SETOR COMERCIAL SUL, QUADRA 09, LOJA 15 (TÉRREO) - EDIFÍCIO PARQUE<br>
            CIDADE CORPORATE, ASA SUL - BRASÍLIA-DF - CEP 70.308.200
        </b>
        <br>
        <br>
        <br>
    </div>
    </div>
</body>

</html>