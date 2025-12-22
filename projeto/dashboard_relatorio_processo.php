<script>
    function carregarGrafico(ano, campo = 'grafico_assunto', arquivado = 3, ordem) {
        $.getJSON("obter_relatorio_processo.php", { ano: ano, tipo: campo, arquivado: arquivado, ordem: ordem}, function (dados) { // chamada ajax para buscar os dados de acordo com id da pergunta
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
            var titulo = 'Quantidade';
            if(campo == 'grafico_motivo'){
                titulo = 'Quantidade de processos por Motivo (' + ano + ') - Total: ' + somaTotal + ' ';
            } else if(campo == 'grafico_assunto'){
                titulo = 'Quantidade de processos por Assunto - Sub assunto (' + ano + ') - Total: ' + somaTotal + ' ';
            }
            const qtdLabels = labels.length;
            const alturaPorLabel = 30; // px (use 28–35 conforme fonte)
            const alturaTotal = qtdLabels * alturaPorLabel;

            document.getElementById('box_'+campo).style.height = alturaTotal + 'px'

            datasets = [{
                label: titulo,
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            }];
        
            const dashboard = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,     // "Assunto - Sub_assunto"
                    datasets: datasets  // [12, 8, ...]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        y: { beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                },
                                autoSpkip: false,
                                maxRotation: 0,    
                                minRotation: 0,
                                align: 'center'
                            }
                        }
                    }
                }
            })
        });
    }
    $(document).ready(function () {
        carregarGrafico('2025', 'grafico_assunto', 3, 'a.assunto, sa.sub_assunto');
        carregarGrafico('2025', 'grafico_motivo', 3, 'm.motivo');
    });
    function atualizarGraficoAssunto() {
        var arquivado = $('#arquivado_assunto').val();
        var ano = $('#ano_assunto').val();
        var ordem = $('#ordem_assunto').val();
        carregarGrafico(ano, 'grafico_assunto', arquivado, ordem);
    }
    function atualizarGraficoMotivo() {
        var arquivado = $('#arquivado_motivo').val();
        var ano = $('#ano_motivo').val();
        var ordem = $('#ordem_motivo').val();
        carregarGrafico(ano, 'grafico_motivo', arquivado, ordem);
    }

</script>