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

            // Preenchendo os dados com base na resposta
            dados.forEach(function (item) {
                atraso_0.push(item.atraso_0); // Adiciona o número de processos dentro do prazo
                atraso_1.push(item.atraso_1); // Adiciona o número de processos fora do prazo
            });

            // Criando o gráfico
            window.dashboardpie = new Chart(ctx, {
                type: 'pie', // Tipo do gráfico
                data: {
                    labels: ["Fora do Prazo", "Dentro do Prazo"], // Labels são as filas
                    datasets: [{
                        label: 'Processos por Fila', // Nome da série
                        data: atraso_0.concat(atraso_1), // Dados (totais) para o gráfico (processos dentro e fora do prazo)
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
                        }
                    }
                }
            });
        }
    });



</script>