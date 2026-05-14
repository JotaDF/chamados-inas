<?php
//Gerente
$mod = 3;
require_once('./verifica_login.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard tarefa</title>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1200px; margin: auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e3e6f0; padding-bottom: 10px; }
        .card1 { background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 25px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-box { background: #fff; padding: 15px; border-left: 4px solid #4e73df; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .stat-label { font-size: 0.75rem; text-transform: uppercase; color: #858796; font-weight: bold; }
        .stat-value { font-size: 1.3rem; font-weight: bold; color: #5a5c69; }
        canvas { max-height: 500px; }
        .full-width { grid-column: 1 / -1; }
    </style>
</head>

<body>
<div class="container">
<?php
include_once('actions/ManterEquipe.php');
include_once('actions/ManterUsuario.php');
include_once('actions/ManterTarefa.php');
include_once('actions/ManterAcao.php');
include_once('actions/ManterEtapa.php');

$manterAcao = new ManterAcao();
$manterEquipe = new ManterEquipe();
$manterUsuario = new ManterUsuario();
$manterTarefa = new ManterTarefa();
$manterEtapa = new ManterEtapa();

if (isset($_REQUEST['tarefa'])) {
    $id_tarefa = $_REQUEST['tarefa'];
    $tarefa = $manterTarefa->getTarefaPorId($id_tarefa);
    //$percentual = round($manterTarefa->getPercentualTarefaPorId($id_tarefa), 1);
    $percente_tarefa = $manterTarefa->getPercentualTarefaPorId($id_tarefa);
    $percentual = round($percente_tarefa['percentual'], 1);

    $etapas = $manterEtapa->listar($id_tarefa);
    $total_etapas = count($etapas);
    ?>
        <div class="header">
            <h1>Painel de acompanhamento</h1>
            <h3><strong>[<small><?= $tarefa->id ?></small>] <?= $tarefa->nome ?></strong></h3>
        </div>
        <div class="stats-grid">
            <div class="stat-box" style="border-left-color: #4e73df;">
                <div class="stat-label">Progresso</div>
                <div class="stat-value"><?=  $percentual ?>%</div>
            </div>
            <div class="stat-box" style="border-left-color: #1cc88a;">
                <div class="stat-label">Total Concluído</div>
                <div class="stat-value"><?= $percente_tarefa['concluido'] ?> Itens</div>
            </div>
            <div class="stat-box" style="border-left-color: #f6c23e;">
                <div class="stat-label">Total Previsto</div>
                <div class="stat-value"><?= $percente_tarefa['total'] ?> Itens</div>
            </div>
            <div class="stat-box" style="border-left-color: #e74a3b;">
                <div class="stat-label">Etapas Mapeadas</div>
                <div class="stat-value"><?= $total_etapas ?></div>
            </div>
        </div>

        <div class="card1">
            <h3>Comparativo Completo: Previsto vs. Concluído</h3>
            <canvas id="mainChart"></canvas>
        </div>

        <div class="card1">
            <h3>Ranking de Conclusão por Percentual (%)</h3>
            <canvas id="rankingChart"></canvas>
        </div>
    </div>

    <script>
        <?php
        $array_etapas = [];
        foreach ($etapas as $obj) {
            $id_etapa = $obj->id;
            if ($obj->data_base > 0) {
                $data_base =$obj->data_base;
            }
            $percente = $manterTarefa->getPercentualEtapaPorId($obj->id);
            $pecentual_etapa = round($percente['percentual'], 1);
            $cor = "#74e074"; // Verde para etapas concluídas
            if ($pecentual_etapa < 50) {
                $cor = "#f1574e"; // Vermelho para etapas não concluídas
            } elseif ($pecentual_etapa < 100 && $pecentual_etapa >= 50) {
                $cor = "#ffcf4b"; //    Laranja para etapas em andamento
            }
            $array_etapas[] = [
                'label' => $obj->nome,
                'total' => $percente['total'],
                'completed' => $percente['concluido'],
                'percente' => $pecentual_etapa,
                'color' => $cor
            ];
        }
        ?>
        //const rawData = [{"label": "8.1.11.1 - Cadastro e Portal", "total": 12, "completed": 11, "color": "#4e73df"}, {"label": "8.1.11.2 - Central Atendimento", "total": 15, "completed": 10, "color": "#1cc88a"}, {"label": "8.1.11.3 - Credenciamento", "total": 10, "completed": 7, "color": "#36b9cc"}, {"label": "8.1.11.4 - Regula\u00e7\u00e3o", "total": 18, "completed": 9, "color": "#f6c23e"}, {"label": "8.1.11.5 - Cota\u00e7\u00e3o e Aquisi\u00e7\u00e3o", "total": 10, "completed": 5, "color": "#e74a3b"}, {"label": "8.1.11.6 - Auditoria Concorrente", "total": 10, "completed": 6, "color": "#4e73df"}, {"label": "8.1.11.7 - Auditoria Retrospectiva", "total": 9, "completed": 5, "color": "#1cc88a"}, {"label": "8.1.11.8 - Faturamento", "total": 12, "completed": 8, "color": "#36b9cc"}, {"label": "8.1.11.9 - Financeiro", "total": 9, "completed": 6, "color": "#f6c23e"}, {"label": "8.1.11.10 - Relat\u00f3rios", "total": 5, "completed": 3, "color": "#e74a3b"}, {"label": "8.1.11.11 - BI (Business Intelligence)", "total": 12, "completed": 2, "color": "#858796"}, {"label": "8.1.11.12 - Aplicativo Mobile", "total": 11, "completed": 9, "color": "#5a5c69"}];
        const rawData = <?= json_encode($array_etapas) ?>;
        // Sorting for ranking chart (highest % first)
        const sortedData = [...rawData].sort((a, b) => (b.percente) - (a.percente));

        // Main Comparison Chart
        new Chart(document.getElementById('mainChart'), {
            type: 'bar',
            data: {
                labels: rawData.map(d => d.label),
                datasets: [
                    {
                        label: 'Previsto',
                        data: rawData.map(d => d.total),
                        backgroundColor: '#b3b3b3'
                    },
                    {
                        label: 'Concluído',
                        data: rawData.map(d => d.completed),
                        backgroundColor: '#74e074'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Ranking Chart (%)
        new Chart(document.getElementById('rankingChart'), {
            type: 'bar',
            data: {
                labels: sortedData.map(d => d.label),
                datasets: [{
                    label: '% Concluído',
                    data: sortedData.map(d => d.percente),
                    backgroundColor: sortedData.map(d => d.color),
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                scales: { x: { max: 100 } },
                plugins: { 
                    legend: { display: false },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        anchor: 'end',
                        align: 'end',
                        offset: 5,
                        formatter: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        });
    </script>
<!-- fim da exibição -->
<div class="row justify-content-center">
<div class="card1 w-75 mx-auto">
    <h5 class="mt-3 ml-2 card-title">Progresso por Etapa</h5>
<?php
    foreach ($etapas as $obj) {
        $percente = $manterTarefa->getPercentualEtapaPorId($obj->id);
        $pecentual_etapa = round($percente['percentual'], 1);
        $cor = "bg-success"; // Verde para etapas concluídas
        if ($pecentual_etapa < 50) {
            $cor = "bg-danger"; // Vermelho para etapas não concluídas
        } elseif ($pecentual_etapa < 100 && $pecentual_etapa >= 50) {
            $cor = "bg-warning"; //    Laranja para etapas em andamento
        }
    ?>
        <p class=" ml-2 card-text"><?= $obj->nome ?></p>
        <div class="row">
            <div class="c0 ml-4 mr-2">
                <div class="text-xs font-weight-bold mb-1"><small class="text-muted">Conclusão: <?= $percente['concluido'] ?>/<?= $percente['total'] ?></small></div>
            </div>                    
            <div class="c1 ml-5">
            </div>                    
            <div class="c2 ml-5">
            </div> 
            <div class="c3 ml-5">
            </div>                  
            <div class="col-auto ml-auto">
                <div class="text-xs font-weight-bold mb-1"><small class="text-muted"><?= $pecentual_etapa ?>% </small></div>
            </div>                    
        </div>
        <div class="mt-2 progress">
            <div id="progressbar" class="progress-bar <?= $cor ?>" role="progressbar" style="width: <?= $pecentual_etapa ?>%;" aria-valuenow="<?= $pecentual_etapa ?>" aria-valuemin="0" aria-valuemax="100"> </div>
        </div>
        <div class="row">
            <div class="c0 ml-4 mr-2">
                <div class="text-xs font-weight-bold mb-1"><small class="text-muted"><?= $percente['concluido'] ?> concluído</small></div>
            </div>   
                                <div class="c1 ml-5">
            </div>                    
            <div class="c2 ml-5">
            </div> 
            <div class="c3 ml-5">
            </div>                  
            <div class="col-auto ml-auto">
                <div class="text-xs font-weight-bold mb-1"><small class="text-muted"><?= $percente['total'] ?> total</small></div>
            </div>                    
        </div>
    <?php
    }
    ?>
</div>
</div>
<?php
}
?>
</body>

</html>