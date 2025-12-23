<script>
    function carregarGrafico(ano, campo = 'grafico_assunto', arquivado = 3, ordem = '') {
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
            var tipo_grafico = 'bar';
            var posicao = 'y';
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
            } else if(campo == 'grafico_ano'){
                titulo = 'Quantidade de processos por Ano';
                tipo_grafico = 'pie';
                posicao = 'x';
            } else if(campo == 'grafico_ano_mes'){
                titulo = 'Quantidade de processos por Mês no ano de ' + ano + ' - Total: ' + somaTotal + ' ';
            }
            // Extraindo os anos e totais dos dados
            var anos = dados.map(function (item) {
                return item.ano; // Extrai os anos
            });

            var totais = dados.map(function (item) {
                return parseInt(item.total); // Extrai os totais, convertendo-os para números
            });
            // Definindo as cores para os anos
            const coresPorAno = {
                '2021': { backgroundColor: 'rgba(60, 120, 216, 0.3)', borderColor: 'rgba(60, 120, 216, 1)' },
                '2022': { backgroundColor: 'rgba(0, 204, 153, 0.3)', borderColor: 'rgba(0, 204, 153, 1)' },
                '2023': { backgroundColor: 'rgba(255, 133, 27, 0.3)', borderColor: 'rgba(255, 133, 27, 1)' },
                '2024': { backgroundColor: 'rgba(156, 89, 210, 0.3)', borderColor: 'rgba(156, 89, 210, 1)' },
                '2025': { backgroundColor: 'rgba(128, 0, 128, 0.3)', borderColor: 'rgba(128, 0, 128, 1)' },
            };
            datasets = [{
                label: titulo,
                data: valores,
                backgroundColor: anos.map(function (ano) {
                    return coresPorAno[ano] ? coresPorAno[ano].backgroundColor : 'rgba(200, 200, 200, 0.3)';
                }),
                borderColor: anos.map(function (ano) {
                    return coresPorAno[ano] ? coresPorAno[ano].borderColor : 'rgba(200, 200, 200, 1)';
                }),
                borderWidth: 1
            }];
        // Ajusta a altura do contêiner com base na quantidade de labels
	    const qtdLabels = labels.length;
        const alturaPorLabel = 16; // px (use 28–35 conforme fonte)
        const alturaTotal = qtdLabels * alturaPorLabel;
        if(campo == 'grafico_ano'){
            document.getElementById('box_'+campo).style.height = '500px';
        } else {
            document.getElementById('box_'+campo).style.height = alturaTotal + 'px';
        }
	    

            // instanciação do gráfico de carregando de dados e condicionais
            const ctx = document.getElementById(campo).getContext('2d');
            //ctx.style.height = (qtd * 25) + 'px'; // 25px por label
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
        carregarGrafico('', 'grafico_ano', 3, '');
        carregarGrafico('2025', 'grafico_ano_mes', 3, '');
        motraGrafico('ano');
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
    function motraGrafico(tabId) {
        // Esconde todas as tabs
        $('#tab_ano').hide();
        $('#tab_ano_mes').hide();
        $('#tab_assunto').hide();
        $('#tab_motivo').hide();
        // Remove a classe active de todos os links
        $('#link_tab_ano').removeClass('active');
        $('#link_tab_ano_mes').removeClass('active');
        $('#link_tab_assunto').removeClass('active');
        $('#link_tab_motivo').removeClass('active');
        // Mostra a tab selecionada
        $('#tab_' + tabId).show()
        $('#link_tab_' + tabId).addClass('active');
    }
</script>
