<script>
    function carregarGrafico(campo = 'grafico_prestador', competencia, quantidade_exibicao = 5, ano_competencia = "2026") {
        $.getJSON("obter_relatorio_execucao.php", { competencia: competencia, quantidade_exibicao: quantidade_exibicao, ano_competencia: ano_competencia }, function (dados) { // chamada ajax para buscar os dados de acordo com id da pergunta
           
        const canvas = document.getElementById(campo);
        // pega o gráfico existente associado ao canvas
        
        // Se o gráfico já existe, destrói usando o nome dinâmico
            const chartExistente = Chart.getChart(canvas);
            if (chartExistente) {
                chartExistente.destroy();
            }

            
            const formatador = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            });

            let labels = [];
            let valores = [];
            let valoresNormalizados = [];
            let somaTotal = 0;
            let tipo_grafico = 'bar';
            let posicao = 'y';

            dados.forEach(item => {
                labels.push(item.razao_social);
                valores.push(item.valor);
                valorNumerico = parseFloat(item.valor.replace(/[^0-9,]/g, '').replace(',', '.'));
                valoresNormalizados.push(valorNumerico);
                somaTotal += valorNumerico;
            });

            // 3. Formata apenas DEPOIS que o loop terminar
            const somaTotalFormatada = formatador.format(somaTotal);
            let qtdLabels = labels.length;
            let qtdExibida = $('#quantidade_exibida').text(qtdLabels);
            let titulo = 'Valores por Competência ' + competencia + ' - Total: ' + somaTotalFormatada + ' ';
            let titulo_todas = 'Prestadores por Competência ' + labels + ' - Total: ' + somaTotalFormatada + ' ';

            let datasets;
            datasets = [{
                label: titulo,
                data: valoresNormalizados,
                backgroundColor: 'rgba(60, 120, 216, 0.4)',
                borderColor: 'rgba(60, 120, 216, 1)',
                borderWidth: 1,
            }];

            if (competencia == 'todas') {
                labels = dados.map(d => d.competencia),
                //posicao = 'x';
                    datasets = [{
                        label: titulo,
                        data: valoresNormalizados,
                        backgroundColor: 'rgba(150, 139, 47, 0.4)',
                        borderColor: 'rgb(189, 180, 100)',
                        borderWidth: 1
                    }]
            }
            // Ajusta a altura do contêiner com base na quantidade de labels
            let alturaPorLabel = 16; // px (use 28–35 conforme fonte)
            let alturaTotal = qtdLabels * alturaPorLabel;
            document.getElementById('box_' + campo).style.height = '500px';
            
            // instanciação do gráfico de carregando de dados e condicionais
            const ctx = document.getElementById(campo).getContext('2d');
            const dashboard = new Chart(ctx, {
                type: tipo_grafico,
                data: {
                    labels: labels,     // "Assunto - Sub_assunto"
                    datasets: datasets  // [12, 8, ...]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: posicao,
                    plugins: {

                    },
                    scales: {
                        y: {
                            beginAtZero: true,
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

    function exportarCSV(campo, competencia) {
        const chart = Chart.getChart(campo);
        if (!chart) {
            alert('Gráfico não encontrado');
            return;
        }
        const exportStrategies = {
            todas: () => ({
                cabecalho: 'Competencia;Valor\n', 
                arquivo: 'relatorio_competencia_valores.csv'
                
            }),
        };

        const strategy = exportStrategies[competencia];

        const { cabecalho, arquivo } = strategy
            ? strategy()
            : {cabecalho: 'Prestador;Valor\n', arquivo: 'relatorio_prestador_valores.csv' };
        let csv = '\uFEFF'; // BOM UTF-8
        csv += cabecalho;

        chart.data.labels.forEach((label, i) => {

            const valor = parseInt(chart.data.datasets[0].data[i]);
            csv += `"${label}";"${valor}"\n`;
        });
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = arquivo;
        a.click();

        URL.revokeObjectURL(url);
    }

    $(document).ready(function () {
        carregarGrafico('grafico_prestador', '11/2025', 5);
    });

    function atualizarGraficoPrestador() {
        var competencia = $('#competencia').val();
        var quantidade_exibicao = $('#quantidade_exibicao').val();
        var ano = $('#ano_competencia').val();

        carregarGrafico('grafico_prestador', competencia, quantidade_exibicao, ano);
    }

    function mostraGrafico(tabId) {
        $('#tab_' + tabId).show()
        $('#link_tab_' + tabId).addClass('active');
    }
</script>