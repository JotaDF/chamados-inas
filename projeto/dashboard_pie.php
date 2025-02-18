<script>
    $(document).ready(function () {
        // Chama a função para carregar os dados e atualizar o gráfico automaticamente
        carregarGraficoPizza();

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
    });


</script>