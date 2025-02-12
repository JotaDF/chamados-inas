<script>
    $(document).ready(function () {
        $('#form_painel').on('submit', function (e) {
            e.preventDefault(); // Evita o recarregamento da página
            var ano = $('#ano').val();
            var url = (ano == 'todos') ? 'obter_dados_ano.php' : 'obter_dados.php';

            // Requisição AJAX para obter os dados
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

        // Função para atualizar o gráfico
        function atualizarGrafico(dados, ano) {
            var ctx = document.getElementById('meuGrafico').getContext('2d');

            // Verifica se o gráfico já foi criado e, se sim, destrói ele antes de criar um novo
            if (window.meuGrafico instanceof Chart) {
                window.meuGrafico.destroy(); // Destrói o gráfico existente
            }

            // Definindo os meses manualmente
            const meses = [
                "Janeiro", "Fevereiro", "Março", "Abril", "Maio",
                "Junho", "Julho", "Agosto", "Setembro", "Outubro",
                "Novembro", "Dezembro"
            ];

            // Ternário para verificar se o ano for 'todos', usar os anos. Se não, usamos os meses.
            var labels = ano === 'todos' ? meses : meses;

            // Definindo as cores para cada ano
            const coresPorAno = {
                '2021': { backgroundColor: 'rgba(60, 120, 216, 0.3)', borderColor: 'rgba(60, 120, 216, 1)' },
                '2022': { backgroundColor: 'rgba(0, 204, 153, 0.3)', borderColor: 'rgba(0, 204, 153, 1)' },
                '2023': { backgroundColor: 'rgba(255, 133, 27, 0.3)', borderColor: 'rgba(255, 133, 27, 1)' },
                '2024': { backgroundColor: 'rgba(156, 89, 210, 0.3)', borderColor: 'rgba(156, 89, 210, 1)' },
                'todos': { backgroundColor: 'rgba(0, 172, 210, 0.7)', borderColor: 'rgba(0, 172, 210, 1)' }
            };

            // Preparar os dados para o gráfico
            var datasets = [];

            // Se o ano for 'todos', criamos um dataset para cada ano
            if (ano === 'todos') {
                for (let anoItem in dados) {
                    datasets.push({
                        label: anoItem,
                        data: Object.values(dados[anoItem]), // Pega os valores dos meses
                        backgroundColor: coresPorAno[anoItem].backgroundColor,
                        borderColor: coresPorAno[anoItem].borderColor,
                        borderWidth: 1
                    });
                }
            } else {
                // Caso contrário, para um único ano, preenche os dados para os meses
                datasets.push({
                    label: ano,
                    data: Object.values(dados), // Pega os valores dos meses
                    backgroundColor: coresPorAno[ano].backgroundColor,
                    borderColor: coresPorAno[ano].borderColor,
                    borderWidth: 1
                });
            }

            // Criando o gráfico
            window.meuGrafico = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Labels definidos com base no ano ou nos meses
                    datasets: datasets // Dados para o gráfico
                },
                options: {
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
