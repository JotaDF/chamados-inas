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

            let  labels = [];
            let  valores = [];
            let  somaTotal = 0;
            let  tipo_grafico = 'bar';
            let  posicao = 'y';
            dados.forEach(item => {
                labels.push(item.label);   // 👈 só texto
                valores.push(parseInt(item.total));  // 👈 só número
                somaTotal += parseInt(item.total);
            });
            let  titulo = 'Quantidade';
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
            /* ================================
                CORES FIXAS POR ANO (PIE)
            ================================== */
            const coresPorAno = {
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
            let datasets;

            if (tipo_grafico === 'pie') {
                datasets = [{
                label: titulo,
                data: valores,
                backgroundColor: labels.map(label =>
                    coresPorAno[label] || 'rgba(200,200,200,0.6)'
                ),
                borderColor: '#fff',
                borderWidth: 1
                }];
            } else {
                datasets = [{
                label: titulo,
                data: valores,
                backgroundColor: 'rgba(60, 120, 216, 0.4)',
                borderColor: 'rgba(60, 120, 216, 1)',
                borderWidth: 1
                }];
            }
        // Ajusta a altura do contêiner com base na quantidade de labels
	    let qtdLabels = labels.length;
        let alturaPorLabel = 16; // px (use 28–35 conforme fonte)
        let alturaTotal = qtdLabels * alturaPorLabel;
        if(campo == 'grafico_ano'){
            document.getElementById('box_'+campo).style.height = '500px';
        } else if(campo == 'grafico_ano_mes'){
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
    function atualizarGraficoAnoMes() {
        var ano = $('#ano_mes').val();
        carregarGrafico(ano, 'grafico_ano_mes', 3, '');
    }
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
