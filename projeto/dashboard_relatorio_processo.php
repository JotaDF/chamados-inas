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
            datasets = [{
                label: titulo,
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            }];
        // Ajusta a altura do contêiner com base na quantidade de labels
	    const qtdLabels = labels.length;
        const alturaPorLabel = 16; // px (use 28–35 conforme fonte)
        const alturaTotal = qtdLabels * alturaPorLabel;
	    document.getElementById('box_'+campo).style.height = alturaTotal + 'px';

            // instanciação do gráfico de carregando de dados e condicionais
            const ctx = document.getElementById(campo).getContext('2d');
            //ctx.style.height = (qtd * 25) + 'px'; // 25px por label
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
        motraGrafico('ano');
        // Carrega o gráfico com o ano atual ao carregar a página
        carregarGraficoAnoAtual();
        // Chama a função para carregar os dados e atualizar o gráfico automaticamente
        carregarGraficoPizza();

        // Quando o formulário for submetido (quando o usuário escolhe um ano diferente)
        $('#form_painel').on('submit', function (e) {
            e.preventDefault(); // Evita o recarregamento da página
            var ano = $('#ano').val();
            var url = (ano == 'todos') ? 'obter_dados_ano.php' : 'obter_dados.php';

            $.ajax({
                url: url,
                method: 'POST',
                data: { ano: ano },
                dataType: 'json',
                success: function (dados) {
                    // Se dados.dados estiver presente, atualiza o gráfico com todos os anos
                    if (dados.dados) {
                        atualizarGrafico(dados.dados, 'todos');
                    } else if (dados.dados_ano) {
                        // Atualiza o gráfico com os dados para o ano selecionado
                        atualizarGrafico(dados.dados_ano, ano);
                    } else if (dados.error) {
                        alert(dados.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Erro na requisição AJAX:", status, error);
                    alert('Erro ao carregar os dados. Verifique o console para mais detalhes.');
                }
            });
        });
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

//=============================================================================================
// Função para carregar o gráfico com o ano atual ao carregar a página
function carregarGraficoAnoAtual() {
    var anoAtual = new Date().getFullYear(); // Pega o ano atual
    var url = (anoAtual == 'todos') ? 'obter_dados_ano.php' : 'obter_dados.php';

    $.ajax({
        url: url,
        method: 'POST',
        data: { ano: anoAtual },
        dataType: 'json',
        success: function (dados) {
            // Se dados.dados estiver presente, atualiza o gráfico com todos os anos
            if (dados.dados) {
                atualizarGrafico(dados.dados, 'todos');
            } else if (dados.dados_ano) {
                // Atualiza o gráfico com os dados para o ano selecionado
                atualizarGrafico(dados.dados_ano, anoAtual);
            } else if (dados.error) {
                alert(dados.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro na requisição AJAX:", status, error);
            alert('Erro ao carregar os dados. Verifique o console para mais detalhes.');
        }
    });
}


// Função para atualizar o gráfico com os dados recebidos
function atualizarGrafico(dados, ano) {
    var ctx = document.getElementById('barra').getContext('2d');

    // Se o gráfico já foi criado, destruímos antes de criar um novo
    if (window.barra instanceof Chart) {
        window.barra.destroy();
    }

    // Definindo os meses manualmente
    const meses = [
        "Janeiro", "Fevereiro", "Março", "Abril", "Maio",
        "Junho", "Julho", "Agosto", "Setembro", "Outubro",
        "Novembro", "Dezembro"
    ];

    // Ternário para verificar se o ano for 'todos', usar os anos. Se não, usamos os meses.
    var labels = meses;
    var title = (ano === 'todos') ? { display: true, text: 'QUANTIDADE DE PROCESSOS POR ANO'} : { display: true, text: 'QUANTIDADE DE PROCESSOS POR MÊS'}
    // Cores diferentes para cada ano
    const coresPorAno = {
        '2021': { backgroundColor: 'rgba(60, 120, 216, 0.3)', borderColor: 'rgba(60, 120, 216, 1)' },
        '2022': { backgroundColor: 'rgba(0, 204, 153, 0.3)', borderColor: 'rgba(0, 204, 153, 1)' },
        '2023': { backgroundColor: 'rgba(255, 133, 27, 0.3)', borderColor: 'rgba(255, 133, 27, 1)' },
        '2024': { backgroundColor: 'rgba(156, 89, 210, 0.3)', borderColor: 'rgba(156, 89, 210, 1)' },
        '2025': { backgroundColor: 'rgba(128, 0, 128, 0.3)', borderColor: 'rgba(128, 0, 128, 1)' },
    };

    // Preparar os dados para o gráfico
    var datasets = [];
    if (ano === 'todos') {
        for (let anoItem in dados) {
            datasets.push({
                label: anoItem,
                data: Object.values(dados[anoItem]),
                backgroundColor: coresPorAno[anoItem].backgroundColor,
                borderColor: coresPorAno[anoItem].borderColor,
                borderWidth: 1
            });
        }
    } else {
        // Caso contrário, para um único ano, preenche os dados para os meses
        datasets.push({
            label: ano,
            data: Object.values(dados),
            backgroundColor: coresPorAno[ano].backgroundColor,
            borderColor: coresPorAno[ano].borderColor,
            borderWidth: 1
        });
    }

    // Criando o gráfico
    window.barra = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // Labels definidos com base no ano ou nos meses
            datasets: datasets // Dados para o gráfico
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 15,
                        }
                    }
                },
                title: title
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
//=============================================================================================
// Função para carregar o gráfico de pizza
function carregarGraficoPizza() {
    // URL da requisição AJAX
    var url = 'obter_dados_pie.php';

    // Requisição AJAX
    $.ajax({
        url: url,
        method: 'POST', 
        dataType: 'json', 
        success: function (dados) {
            console.log(dados); 
            if (dados.dados && Array.isArray(dados.dados)) {
                // Atualiza o gráfico com os dados retornados
                atualizarGrafico(dados.dados);
            } else {
                alert('Erro nos dados retornados ou nenhum dado encontrado.');
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro na requisição AJAX:", status, error);
            alert('Erro ao carregar os dados. Verifique o console para mais detalhes.');
        }
    });

}

// Função para atualizar o gráfico de pizza
function atualizarGrafico(dados) {
    var ctx = document.getElementById('dashboardpie').getContext('2d');

    // Se o gráfico já existir, destrua-o antes de criar um novo
    if (window.dashboardpie instanceof Chart) {
        window.dashboardpie.destroy();
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

    // Preparando os datasets para o gráfico
    var datasets = [{
        label: 'Processos por Ano', // Nome da série
        data: totais, // Dados (totais) para o gráfico
        backgroundColor: anos.map(function (ano) {
            return coresPorAno[ano] ? coresPorAno[ano].backgroundColor : 'rgba(200, 200, 200, 0.3)';
        }),
        borderColor: anos.map(function (ano) {
            return coresPorAno[ano] ? coresPorAno[ano].borderColor : 'rgba(200, 200, 200, 1)';
        }),
        borderWidth: 1
    }];

    // Criando o gráfico
    window.dashboardpie = new Chart(ctx, {
        type: 'pie', // Tipo do gráfico
        data: {
            labels: anos, // Labels (anos)
            datasets: datasets // Dados para o gráfico
        },
        options: {
            responsive: false,
            plugins: {
                legend: { position: 'top', 
                    labels: {
                        font: {
                            size: 15,
                        }
                    }
                },
                title: { display: true, text: 'QUANTIDADE DE PROCESSOS POR ANO'}
            },
            scales: {
                y: {
                    beginAtZero: true // Garante que o gráfico comece do zero
                }
            }
        }
    });
}

</script>
