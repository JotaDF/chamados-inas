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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1200px; margin: auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e3e6f0; padding-bottom: 10px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 25px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-box { background: #fff; padding: 15px; border-left: 4px solid #4e73df; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .stat-label { font-size: 0.75rem; text-transform: uppercase; color: #858796; font-weight: bold; }
        .stat-value { font-size: 1.3rem; font-weight: bold; color: #5a5c69; }
        canvas { max-height: 500px; }
        .full-width { grid-column: 1 / -1; }
    </style>
</head>

<body id="page-top">
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
            <h1>Relatório Consolidado MAIDA ECO - V3</h1>
            <p>Visão Integral de Todos os Módulos do Contrato</p>
        </div>

        <div class="stats-grid">
            <div class="stat-box" style="border-left-color: #4e73df;">
                <div class="stat-label">Progresso</div>
                <div class="stat-value"><?=  $percentual ?>?>%</div>
            </div>
            <div class="stat-box" style="border-left-color: #1cc88a;">
                <div class="stat-label">Total Concluído</div>
                <div class="stat-value"><?= $percente_tarefa['concluido'] ?>?> Itens</div>
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

        <div class="card">
            <h3>Comparativo Completo: Previsto vs. Concluído</h3>
            <canvas id="mainChart"></canvas>
        </div>

        <div class="card">
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

            $array_etapas[] = [
                'label' => $obj->nome,
                'total' => $percente['total'],
                'completed' => $percente['concluido'],
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)) // Cor aleatória para cada etapa
            ];
        }
        ?>
        //const rawData = [{"label": "8.1.11.1 - Cadastro e Portal", "total": 12, "completed": 11, "color": "#4e73df"}, {"label": "8.1.11.2 - Central Atendimento", "total": 15, "completed": 10, "color": "#1cc88a"}, {"label": "8.1.11.3 - Credenciamento", "total": 10, "completed": 7, "color": "#36b9cc"}, {"label": "8.1.11.4 - Regula\u00e7\u00e3o", "total": 18, "completed": 9, "color": "#f6c23e"}, {"label": "8.1.11.5 - Cota\u00e7\u00e3o e Aquisi\u00e7\u00e3o", "total": 10, "completed": 5, "color": "#e74a3b"}, {"label": "8.1.11.6 - Auditoria Concorrente", "total": 10, "completed": 6, "color": "#4e73df"}, {"label": "8.1.11.7 - Auditoria Retrospectiva", "total": 9, "completed": 5, "color": "#1cc88a"}, {"label": "8.1.11.8 - Faturamento", "total": 12, "completed": 8, "color": "#36b9cc"}, {"label": "8.1.11.9 - Financeiro", "total": 9, "completed": 6, "color": "#f6c23e"}, {"label": "8.1.11.10 - Relat\u00f3rios", "total": 5, "completed": 3, "color": "#e74a3b"}, {"label": "8.1.11.11 - BI (Business Intelligence)", "total": 12, "completed": 2, "color": "#858796"}, {"label": "8.1.11.12 - Aplicativo Mobile", "total": 11, "completed": 9, "color": "#5a5c69"}];
        const rawData = <?= json_encode($array_etapas) ?>;
        // Sorting for ranking chart (highest % first)
        const sortedData = [...rawData].sort((a, b) => (b.completed/b.total) - (a.completed/a.total));

        // Main Comparison Chart
        new Chart(document.getElementById('mainChart'), {
            type: 'bar',
            data: {
                labels: rawData.map(d => d.label),
                datasets: [
                    {
                        label: 'Previsto',
                        data: rawData.map(d => d.total),
                        backgroundColor: '#eaecf4'
                    },
                    {
                        label: 'Concluído',
                        data: rawData.map(d => d.completed),
                        backgroundColor: '#4e73df'
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
                    data: sortedData.map(d => Math.round((d.completed / d.total) * 100)),
                    backgroundColor: sortedData.map(d => d.color),
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                scales: { x: { max: 100 } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
<!-- fim da exibição -->
<?php
}
?>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


</body>

</html>