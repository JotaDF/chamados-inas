<script>
    $(document).ready(function () {
        // Chama a função para carregar os dados e atualizar o gráfico automaticamente
        carregarGraficoPizza();

        function carregarGraficoPizza() {
            // URL da requisição AJAX
            var url = 'obter_dados_regulacao.php';

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

            // Preparando os datasets para o gráfico
            var atraso_0 = [];
            var atraso_1 = [];
            var atraso_0_p = [];
            var atraso_1_p = [];

            // Preenchendo os dados com base na resposta
            dados.forEach(function (item) {
                atraso_0.push(item.atraso_0); // Adiciona o número de processos dentro do prazo
                atraso_1.push(item.atraso_1); // Adiciona o número de processos fora do prazo
                var total = parseInt(item.atraso_0) + parseInt(item.atraso_1);

                atraso_0_p.push(Math.round(item.atraso_0 * 100 / total)); // Adiciona o percentual de processos dentro do prazo
                atraso_1_p.push(Math.round(item.atraso_1 * 100 / total)); // Adiciona o percentual de processos fora do prazo
            });

            // Criando o gráfico
            window.dashboardpie = new Chart(ctx, {
                type: 'pie', // Tipo do gráfico
                data: {
                    labels: [
                        "Dentro do Prazo " + atraso_0_p[0] + "%", // Label com a porcentagem calculada
                        "Fora do Prazo " + atraso_1_p[0] + "%"  // Label com a porcentagem calculada
                    ], // Labels com os percentuais calculados
                    datasets: [{
                        label: 'Processos por Fila', // Nome da série
                        data: [atraso_0[0], atraso_1[0]], // Dados (totais) para o gráfico (processos dentro e fora do prazo)
                        backgroundColor: ['#36A2EB', '#FF6384'], // Cor para cada pedaço do gráfico
                        hoverOffset: 4
                    }]
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
                        title: {
                            display: true,
                            text: 'Dentro vs Fora do Prazo'
                        },
                        datalabels: {
                            // Exibindo o valor real (dados reais do gráfico) no rótulo
                            formatter: function (value, context) {
                                // Verifica o índice da partição atual
                                const index = context.dataIndex;

                                // Retorna a porcentagem de acordo com o índice
                                if (index === 0) {
                                    return atraso_0_p[0] + "%"; // Mostra a porcentagem de atraso_0
                                } else if (index === 1) {
                                    return atraso_1_p[0] + "%"; // Mostra a porcentagem de atraso_1
                                }
                            },
                            color: '#ffff', // Cor do texto dos rótulos
                            font: {
                                size: 18 // Tamanho da fonte
                            },
                            align: 'center', // Alinhamento central dos rótulos
                            anchor: 'center' // Ancorar os rótulos no centro
                        }

                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    });
</script>
