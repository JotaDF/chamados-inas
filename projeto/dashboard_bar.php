<script>
    $(document).ready(function () {
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

        // Carregar o gráfico com o ano atual ao carregar a página
        carregarGraficoAnoAtual();

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
    });
</script>