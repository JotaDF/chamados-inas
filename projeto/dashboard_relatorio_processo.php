<script>
    function carregarGrafico(ano, campo = 'grafico_assunto', arquivado = 0) {
        $.getJSON("obter_relatorio_processo.php", { ano: ano, tipo: campo, arquivado: arquivado}, function (dados) { // chamada ajax para buscar os dados de acordo com id da pergunta
            // Se o gráfico já existe, destrói usando o nome dinâmico
            const canvas = document.getElementById(campo);
            // pega o gráfico existente associado ao canvas
            const chartExistente = Chart.getChart(canvas);
            if (chartExistente) {
                chartExistente.destroy();
            }

            const labels = [];
            const valores = [];
            var somaTotal = 0;
            dados.forEach(item => {
                labels.push(item.label);   // 👈 só texto
                valores.push(item.total);  // 👈 só número
                somaTotal += item.total;
            });
            datasets = [{
                label: 'Quantidade de processos por Assunto - Sub_assunto (' + ano + ') - Total: ' + somaTotal + ' ',
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            }];
        
            // instanciação do gráfico de carregando de dados e condicionais
            const ctx = document.getElementById(campo).getContext('2d');
            const dashboard = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,     // "Assunto - Sub_assunto"
                    datasets: datasets  // [12, 8, ...]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }

            })
        });
    }
    $(document).ready(function () {
        carregarGrafico('<?= $ano ?>', '<?= $tipo ?>');
    });
    function atualizarGraficoAssunto() {
        var arquivado = 3;
        if($('#arquivado_sim').is(':checked')) {
           arquivado = 1;
        } else if($('#arquivado_nao').is(':checked')) {
           arquivado = 0;
        }
        var ano = $('#ano_assunto').val();
        carregarGrafico(ano, 'grafico_assunto', arquivado);
    }


</script>