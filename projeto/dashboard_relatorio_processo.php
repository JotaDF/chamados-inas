<script>

    function mostrarSemDados(campo) {
        const canvas = document.getElementById(campo);

        const chartExistente = Chart.getChart(canvas);
        if (chartExistente) {
            chartExistente.destroy();
        }

        const box = document.getElementById('box_' + campo);
        if (box) {
            box.style.height = '120px';
        }

        canvas.width = canvas.width;
    }

    function carregarGrafico(filtros) {
        $.getJSON("obter_relatorio_processo.php", filtros) // chamada ajax para buscar os dados de acordo com id da pergunta
            .done(function (dados) {
                const semDados = !dados || !Array.isArray(dados) || dados.length === 0 || dados == null;

                if (semDados) {
                    mostrarSemDados(filtros.tipo);
                    return;
                }

                processarGrafico(filtros, dados);
            })
            .fail(function () {
                // falha de rede, servidor, ou JSON inválido
                mostrarSemDados(filtros.tipo);
            });
    }

    function processarGrafico(filtros, dados) {
        // Se o gráfico já existe, destrói usando o nome dinâmico
        const campo = filtros.tipo;
        const ano = filtros.ano;
        const canvas = document.getElementById(campo);

        // pega o gráfico existente associado ao canvas
        const chartExistente = Chart.getChart(canvas);
        if (chartExistente) {
            chartExistente.destroy();
        }

        let labels = [];
        let valores = [];
        let somaTotalValoresFinanceiros = 0;
        let valoresFinanceiros = [];
        let somaTotal = 0;
        let tipo_grafico = 'bar';
        let posicao = 'y';

        const formatador = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        });

        dados.forEach(item => {
            labels.push(item.label);   // 👈 só texto
            valores.push(parseInt(item.total));  // 👈 só número
            valoresFinanceiros.push(parseFloat(item.valor_total));
            somaTotal += parseInt(item.total);
            //console.log("mes: " + item.label + " total: " + item.total + " valor: " + item.valor_total);
            somaTotalValoresFinanceiros += item.valor_total != 0
                ? parseFloat(item.valor_total)
                : 0;

        });
        const somaTotalNumerica = formatador.format(somaTotalValoresFinanceiros);
        let titulo = 'Quantidade';

        if (campo == 'grafico_motivo') {
            titulo = 'Quantidade de processos por Motivo (' + ano + ') - Total: ' + somaTotal + ' ';
        }

        if (campo == 'grafico_assunto') {
            titulo = 'Quantidade de processos por Assunto - Sub assunto (' + ano + ') - Total: ' + somaTotal + ' ';
        }

        if (campo == 'grafico_ano') {
            titulo = 'Quantidade de processos por Ano';
            tipo_grafico = 'pie';
            posicao = 'x';
        }

        if (campo == 'grafico_ano_mes') {
            titulo = 'Quantidade de processos por Mês no ano de ' + ano + ' - Total: ' + somaTotal + ' ';
        }

        if (campo == 'grafico_tipo_valor') {
            titulo = 'Quantidade de processos por Mês no ano de ' + ano + ' - Total: ' + somaTotalNumerica + ' ';
        }
        /* ================================
            CORES FIXAS POR ANO (PIE)
        ================================== */
        const coresPorAno = {
            '2019': 'rgba(212, 148, 137, 0.7)',
            '2020': 'rgba(212, 204, 137, 0.7)',
            '2021': 'rgba(105, 139, 194, 0.7)',
            '2022': 'rgba(132, 218, 196, 0.7)',
            '2023': 'rgba(209, 159, 115, 0.7)',
            '2024': 'rgba(169, 144, 190, 0.7)',
            '2025': 'rgba(184, 81, 184, 0.7)'
        };
        /* ================================
           DATASET
       ================================== */
        let backgroundColor = 'rgba(60, 120, 216, 0.4)';
        let borderColor = 'rgba(60, 120, 216, 1)';

        if (tipo_grafico === 'pie') {
            backgroundColor = labels.map(label => coresPorAno[label] || 'rgba(200,200,200,0.6)');
            borderColor = '#fff';
        }

        const datasets = [{
            label: titulo,
            data: valoresFinanceiros.some(v => v > 0)
                ? valoresFinanceiros
                : valores,
            backgroundColor,
            borderColor,
            borderWidth: 1
        }];

        // Ajusta a altura do contêiner com base na quantidade de labels
        let qtdLabels = labels.length;
        let alturaPorLabel = 16; // px (use 28–35 conforme fonte)
        let alturaTotal = qtdLabels * alturaPorLabel;

        const alturasFixas = {
            grafico_ano: '500px',
            grafico_ano_mes: '500px',
            grafico_tipo_valor: '500px',
        };

        const elemento = document.getElementById('box_' + campo);
        elemento.style.height = alturasFixas[campo] || (alturaTotal + 'px');

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
        });
    }

    function exportarCSV(idGrafico) {
        const chart = Chart.getChart(idGrafico);
        if (!chart) {
            alert('Gráfico não encontrado');
            return;
        }
        const exportStrategies = {
            grafico_ano: () => ({
                cabecalho: 'Ano;Quantidade\n',
                arquivo: 'relatorio_ano.csv'
            }),
            grafico_ano_mes: () => ({
                cabecalho: 'Mês;Quantidade\n',
                arquivo: 'relatorio_ano_mes.csv'
            }),
            grafico_tipo_valor: () => ({
                cabecalho: 'Ano;Quantidade\n',
                arquivo: 'relatorio_tipo_valor.csv'
            }),
            grafico_assunto: () => ({
                cabecalho: 'Mês;Quantidade\n',
                arquivo: 'relatorio_assunto.csv'
            }),
            grafico_motivo: () => ({
                cabecalho: 'Mês;Quantidade\n',
                arquivo: 'relatorio_motivo.csv'
            })
        };

        const strategy = exportStrategies[idGrafico];

        const { cabecalho, arquivo } = strategy
            ? strategy()
            : { cabecalho: 'Item;Valor\n', arquivo: 'relatorio.csv' };
        let csv = '\uFEFF'; // BOM UTF-8
        csv += cabecalho;

        chart.data.labels.forEach((label, i) => {
            const valor = chart.data.datasets[0].data[i];
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
        const graficos = [
            { ano: '2025', tipo: 'grafico_assunto', arquivado: 3, ordem: 'a.assunto, sa.sub_assunto' },
            { ano: '2025', tipo: 'grafico_motivo', arquivado: 3, ordem: 'm.motivo' },
            { ano: '', tipo: 'grafico_ano', arquivado: 3, ordem: '' },
            { ano: '2025', tipo: 'grafico_ano_mes', arquivado: 3, ordem: '' },
            { ano: '2025', tipo: 'grafico_tipo_valor', tipo_valor: 2, ordem: '', },
        ];

        graficos.forEach(carregarGrafico);

        motraGrafico('ano');
    });

    function atualizarGrafico(tipo, sufixoFiltros, sufixoAno = sufixoFiltros) {
        const filtros = {
            ano: $('#ano_' + sufixoAno).val(),
            tipo: tipo,
            arquivado: $('#arquivado_' + sufixoFiltros).val(),
            ordem: $('#ordem_' + sufixoFiltros).val()
        };

        if (tipo === 'grafico_tipo_valor') {
            filtros.tipo_valor = $('#tipo_valor').val();
        }

        carregarGrafico(filtros);
    }

    function atualizarGraficoAnoMes() { atualizarGrafico('grafico_ano_mes', 'ano', 'mes'); }

    function atualizarGraficoAssunto() { atualizarGrafico('grafico_assunto', 'assunto'); }

    function atualizarGraficoMotivo() { atualizarGrafico('grafico_motivo', 'motivo'); }

    function atualizarGraficoTipoValor() { atualizarGrafico('grafico_tipo_valor', 'tipo_valor'); }

    function motraGrafico(tabId) {
        const tabs = ['ano', 'ano_mes', 'assunto', 'motivo', 'tipo_valor'];

        tabs.forEach(id => {
            $('#tab_' + id).hide();
            $('#link_tab_' + id).removeClass('active');
        });

        $('#link_tab_' + tabId).addClass('active');
        $('#tab_' + tabId).show();
    }
</script>