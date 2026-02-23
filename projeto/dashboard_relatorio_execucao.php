<script>
    function carregarGrafico(campo = 'grafico_notas_pagamento', competencia, quantidade_exibicao = 5, ano_competencia = "2026", adm = new URLSearchParams(window.location.search).get('adm')) {
        $.getJSON("obter_relatorio_execucao.php", { competencia: competencia, quantidade_exibicao: quantidade_exibicao, ano_competencia: ano_competencia, campo: campo, adm: adm }, function (dados) {
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
            let tipo_grafico = 'bar';
            let posicao = 'y';


            let somaTotal = parseFloat(dados['total'] || 0);

            if (dados['dados'] && Array.isArray(dados['dados'])) {
                dados['dados'].forEach(item => {
                    // 2. Decide o que exibir no rótulo: 
                    // Se tiver razao_social (Ranking), usa ela. Se não, usa a competencia (Evolução Mensal).
                    let labelExibicao = item.razao_social ? item.razao_social : item.competencia;
                    labels.push(labelExibicao);
                    // 3. Guarda o valor original formatado (opcional, para tooltips)
                    valores.push(item.valor);

                    // 4. Converte o valor para número puro (essencial para o Chart.js)
                    let valorNumerico = parseFloat(item.valor.replace(/[^0-9,]/g, '').replace(',', '.'));
                    valoresNormalizados.push(valorNumerico);
                });
            }

            const somaTotalFormatada = formatador.format(somaTotal);
            let qtdLabels = labels.length;
            let qtdExibidaPagamento = $('#quantidade_exibida_nota_pagamento').text(qtdLabels);
            let qtdExibidaGlosa = $('#quantidade_exibida_glosa').text(qtdLabels);
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
                labels = dados['dados'].map(d => d.competencia),
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

            let alturaPorLabel = 20; // px (use 28–35 conforme fonte)
            let alturaTotal = qtdLabels * alturaPorLabel;
            document.getElementById('box_' + campo).style.height = '500px';
            document.getElementById('box_' + campo).style.height = alturaTotal + 'px';
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

    function exportarCSV(campo, competencia, adm) {
        const canvas = document.getElementById(campo);
        const chart = Chart.getChart(canvas);
        if (!chart) {
            alert('Gráfico não encontrado');
            return;
        }

        const exportStrategies = {
            grafico_nota_pagamento: {
                todas: () => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: 'relatorio_competencia_valores_pagamento.csv'
                }),
                especifica: (competencia) => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: `relatorio_competencia_${competencia.replace('/', '-')}_valores_pagamento.csv`
                })
            },

            grafico_nota_glosa: {
                todas: () => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: 'relatorio_competencia_valores_glosa.csv'
                }),
                especifica: (competencia) => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: `relatorio_competencia_${competencia.replace('/', '-')}_valores_glosa.csv`
                })
            }
        };
        const exportStrategiesAdm = {
            grafico_nota_pagamento: {
                todas: () => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: 'relatorio_adm_competencia_valores_pagamento.csv'
                }),
                especifica: (competencia) => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: `relatorio_adm_competencia_${competencia.replace('/', '-')}_valores_pagamento.csv`
                })
            },

            grafico_nota_glosa: {
                todas: () => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: 'relatorio_competencia_valores_glosa.csv'
                }),
                especifica: (competencia) => ({
                    cabecalho: 'Competencia;Valor\n',
                    arquivo: `relatorio_competencia_${competencia.replace('/', '-')}_valores_glosa.csv`
                })
            }
        };


        const estrategiaGrafico = adm == "1" ? exportStrategies[campo] : exportStrategiesAdm[campo];

        const { cabecalho, arquivo } =
            competencia === 'todas'
                ? estrategiaGrafico.todas()
                : estrategiaGrafico.especifica(competencia);

        let csv = '\uFEFF'; // BOM UTF-8
        csv += cabecalho;

        chart.data.labels.forEach((label, i) => {

            const valor = parseFloat(chart.data.datasets[0].data[i]);
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
        carregarGrafico('grafico_nota_pagamento', '11/2025', 5);
        carregarGrafico('grafico_nota_glosa', '11/2025', 5);
        mostraGrafico('grafico_nota_pagamento');
    });

    function atualizarGraficoPagamento() {
        var competencia = $('#competencia_pagamento').val();
        var quantidade_exibicao = $('#quantidade_exibicao_pagamento').val();
        var ano = $('#ano_competencia_pagamento').val();
        carregarGrafico('grafico_nota_pagamento', competencia, quantidade_exibicao, ano);
    }
    function atualizarGraficoGlosa() {
        var competencia = $('#competencia_glosa').val();
        var quantidade_exibicao = $('#quantidade_exibicao_glosa').val();
        var ano = $('#ano_competencia_glosa').val();
        carregarGrafico('grafico_nota_glosa', competencia, quantidade_exibicao, ano);
    }

    function mostraGrafico(tabId) {
        // Percorre todas as tabs
        $('[id^="tab_"]').each(function () {
            // Obtém o identificador da tab atual
            const idAtual = this.id.replace('tab_', '');
            // Esconde as tabs que não são a selecionada
            if (idAtual !== tabId) {
                $(this).hide();
                $('#link_tab_' + idAtual).removeClass('active');
            }
            // Mostra apenas a tab selecionada
            if (idAtual === tabId) {
                $(this).show();
                $('#link_tab_' + idAtual).addClass('active');
            }
        });
    }



</script>