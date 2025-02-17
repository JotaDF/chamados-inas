<script>
    $(document).ready(function () {
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

        
        function atualizarGrafico(dados, ano) {
            var ctx = document.getElementById('meuGrafico').getContext('2d');

            if (window.meuGrafico instanceof Chart) {
                window.meuGrafico.destroy(); 
            }

            // Definindo os meses manualmente
            const meses = [
                "Janeiro", "Fevereiro", "Março", "Abril", "Maio",
                "Junho", "Julho", "Agosto", "Setembro", "Outubro",
                "Novembro", "Dezembro"
            ];

            // Ternário para verificar se o ano for 'todos', usar os anos. Se não, usamos os meses.
            var labels = meses;

            
            const coresPorAno = {
                '2021': { backgroundColor: 'rgba(60, 120, 216, 0.3)', borderColor: 'rgba(60, 120, 216, 1)'},
                '2022': { backgroundColor: 'rgba(0, 204, 153, 0.3)', borderColor: 'rgba(0, 204, 153, 1)'},
                '2023': { backgroundColor: 'rgba(255, 133, 27, 0.3)', borderColor: 'rgba(255, 133, 27, 1)'},
                '2024': { backgroundColor: 'rgba(156, 89, 210, 0.3)', borderColor: 'rgba(156, 89, 210, 1)'},
                '2025': { backgroundColor: 'rgba(128, 0, 128, 0.3)', borderColor: 'rgba(128, 0, 128, 1)'},
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
            window.meuGrafico = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Labels definidos com base no ano ou nos meses
                    datasets: datasets // Dados para o gráfico
                },
                options: {
                    responsive: true,
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
