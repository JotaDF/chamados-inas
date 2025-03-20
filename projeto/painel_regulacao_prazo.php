<?php
$mod = 14;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Relatorio SLA Regulação</title>

    <!-- Custom fonts for this template-->
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
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#acessos').DataTable({
                paging: false, // Desativa a paginação
                searching: true, // Habilita a pesquisa
                ordering: true, // Habilita a ordenação
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5', // Exporte para Excel
                        text: 'Exportar para Excel', // Texto do botão
                        className: 'btn btn-sm btn-primary', // Classe do botão
                        title: 'Dados da Fila', // Título do arquivo Excel
                        exportOptions: {
                            // Configuração para exportar apenas dados da tabela, excluindo cabeçalhos extras
                            columns: ':visible'
                        }
                    }
                ],
                pageLength: -1, // Exibe todos os registros sem paginação
                language: {
                    search: "Buscar:",
                    paginate: {
                        previous: "Anterior",
                        next: "Próximo"
                    },
                    lengthMenu: "Exibir _MENU_ registros por página",
                    info: "Exibindo _START_ a _END_ de _TOTAL_ registros"
                }
            });
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa_fila.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('action=processarFila&fila=' + encodeURIComponent(fila));

        let atualizaFoiChamado = false;
        function gifLoading() {
            var div = document.getElementById("atualiza_botao");
            div.style.display = 'none';
            let gif = document.createElement('img')
            gif.src = './img/loading_sla_regulacao.gif';
            gif.className = 'rounded mx-auto d-block';
            document.getElementById('conteudo').appendChild(gif)
            let carregamento = document.createElement('p')
            carregamento.id = 'texto';
            texto.innerText = 'Processando...';
        }
    </script>
    <style>
        #bar {
            width: 100%;
            max-width: 650px;
            /* Limitar a largura do card-body */
            height: 400px;
            /* Limitar a largura do card-body */
            margin: 0 auto;
            /* Limitar a largura do card-body */
        }

        #pie {
            width: 100%;
            max-width: 650px;
            /* Limitar a largura do gráfico de pizza */
            height: 420px;
            /* Limitar a largura do gráfico de pizza */
            margin: 0 auto;
            /* Limitar a largura do gráfico de pizza */
        }


        #barra {
            width: 100%;
            max-width: 500px;
            /* Largura ajustada para o gráfico de barras */
            height: 250px;
            /* Altura ajustada para o gráfico de barras */
            display: block;
            /* Certificar que o gráfico de barras é um bloco */
            margin: 0 auto;
            /* Centralizar o gráfico de barras horizontalmente */
        }

        #dashboardpie {
            width: 100%;
            max-width: 600px;
            /* Largura ajustada para o gráfico de pizza */
            height: 150px;
            /* Altura ajustada para o gráfico de pizza */
            display: block;
            /* Certificar que o gráfico de pizza é um bloco */
            margin: 0 auto;
            /* Centralizar o gráfico de pizza horizontalmente */
        }

        .desabilitada {
            pointer-events: none; /* Desabilita a interação com a div */
            opacity: 0.5;  
        }
    </style>

    </style>

<body id="page-top">
    <div id="wrapper">
        <?php include './menu_sla.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include './top_bar.php'; ?>
            <?php
            $msg = "";
            if (isset($_REQUEST['msg'])) {
                $id_msg = $_REQUEST['msg'];
                if ($id_msg == 1) {
                    $msg = "Prazos atualizados com sucesso!";
                }
            }
            ?>
            <div class="alerta">
                <?php if ($msg) { ?>
                    <div class="alert alert-info fade " role="alert" id="alerta" style="width: 1000px; margin: 20px">
                        <?php echo $msg; ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            // Exibir o alerta ao carregar a página
                            var alerta = document.getElementById("alerta");
                            alerta.classList.add("show");

                            // Ocultar o alerta após 2 segundos
                            setTimeout(function () {
                                alerta.classList.remove("show");
                            }, 2000);
                        });

                    </script>
                <?php } ?>
            </div>
            <div id="content">
                <div class="d-flex justify-content-center flex-wrap">

                    <div class="card mb-4 border-primary" style="width: 100%; max-width: 45%; margin-right: 25px;">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width: 100%;">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-check-square fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span class="h5 m-0 font-weight text-white">Painel</span>
                            </div>
                            <form id="form_atualiza" style="height: 10px;">
                                <input type="hidden" name="update_painel">
                                <input type="hidden" id="id_usuario" name="id_usuario"
                                    value="<?= $usuario_logado->id ?>">
                                <div class="col text-right" style="max-width:30%; display: flex; justify-content: space-between;" id="atualiza_botao">
                                    <button id="atualiza" name="atualiza" class="btn btn-sm text-white border"
                                        type="button" onclick="gifLoading()">
                                        Atualizar Prazos
                                    </button>&nbsp;&nbsp;
                                    <button id="exportButton" class="btn btn-sm text-white border"
                                        type="button">Exportar para Excel</button>
                                </div>
                            </form>
                        </div>

                        </form>
                        <script>
                            document.getElementById('atualiza').addEventListener('click', function () {
                                const form = document.getElementById('form_atualiza');
                                form.action = "processa_prazo_regulacao.php"; // Define a ação para o processo
                                form.method = "POST"; // Garantir que o método POST seja usado
                                form.submit(); // Submete o formulário
                            });

                        </script>
                        </script>
                        <div class="card-body">
                            <?php
                            include('actions/ManterSlaRegulacao.php');
                            $manterSlaregulacao = new ManterSlaRegulacao;
                            $regulacao = $manterSlaregulacao->getTotaisAtraso();
                            $total = $manterSlaregulacao->getTotalGuias();
                            $atualizacao = $manterSlaregulacao->getUltimaAtualizacao();
                            ?>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <!-- Seção de "Regulação" -->
                                <?php if ($regulacao) { ?>
                                    <div style="text-align: left; margin-left: 20px;">
                                        <p><strong>Total de Guias:</strong> <?php echo $total; ?></p>
                                        <p style="color: #36A2EB"><strong>Dentro do Prazo:</strong><strong>
                                                <?php echo $regulacao['atraso_0']; ?></strong></p>
                                        <p style="color: #FF6384"><strong>Fora do Prazo:</strong><strong>
                                                <?php echo $regulacao['atraso_1']; ?></strong></p>
                                    </div>
                                    <div>
                                        <div id="conteudo">
                                            <div id="texto">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- Seção de "Última Atualização"-->
                                <?php if ($atualizacao) {
                                    $atualizado = $atualizacao['atualizacao'];
                                    $nome = $atualizacao['nome'];
                                    $data = new DateTime($atualizado);
                                    $data_atualizada_formatada = $data->format('d/m/Y H:i:s');
                                    ?>
                                    <div style="text-align: right; margin-right: 20px;">
                                        <p style="font-size: 15px"><strong>Atualizado Em:
                                            </strong><?php echo $data_atualizada_formatada; ?></p>
                                        <p style="font-size: 15px"><strong>Por: </strong><?php echo $nome; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="table-responsive">
                                <table id="acessos" class="table-sm table-striped table-bordered dt-responsive nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fila</th>
                                            <th scope="col">Dentro do Prazo</th>
                                            <th scope="col">Fora do Prazo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include("get_regulacao_prazo.php"); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card para o Gráfico -->
                    <div class="card mb-4 border-primary"
                        style="width: 100%; max-width: 555px; height: 600px; margin-left: 25px; margin-right: 25px;">
                        <div class="row ml-0 card-header py-2 bg-gradient-primary" style="width: 100%;">
                            <div class="col-sm ml-0" style="max-width:50px;">
                                <i class="fa fa-chart-pie fa-2x text-white"></i>
                            </div>
                            <div class="col mb-0">
                                <span style="align:left;" class="h5 m-0 font-weight text-white">Gráfico de
                                    Acompanhamento - SLA - GDF</span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 0;">
                            <!-- Gráfico -->
                            <canvas id="dashboardpie" style="width: 90%; height: 100%;"></canvas>
                            <?php include('dashboard_prazo_regulacao.php'); ?>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('exportButton').addEventListener('click', function () {
                        var wb = XLSX.utils.table_to_book(document.getElementById('acessos'), { sheet: "Sheet 1" });
                        XLSX.writeFile(wb, "dados_fila.xlsx");
                    });
                </script>
            </div>
            <?php include './rodape.php'; ?>
</body>