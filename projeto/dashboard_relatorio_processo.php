<script>
    function carregarGrafico(ano, campo = 'grafico_assunto') {
        $.getJSON("obter_relatorio_processo.php", { ano: ano, tipo: campo}, function (dados) { // chamada ajax para buscar os dados de acordo com id da pergunta
            // Se o gráfico já existe, destrói usando o nome dinâmico
            if (window[campo] instanceof Chart) {
                window[campo].destroy();
            }
            const labels = [];
            const valores = [];
            dados.forEach(item => {
                labels.push(item.label);   // 👈 só texto
                valores.push(item.total);  // 👈 só número
            });
            datasets = [{
                label: 'Quantidade de processos por Assunto - Sub_assunto (' + ano + ')',
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            }];
        
            // instanciação do gráfico de carregando de dados e condicionais
            const ctx = document.getElementById(campo).getContext('2d');
            const dashboard = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,     // "Assunto - Sub_assunto"
                    datasets: datasets  // [12, 8, ...]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }

            })
        });
    }
    $(document).ready(function () {
        carregarGrafico('<?= $ano ?>', '<?= $tipo ?>');
    });
    function atualizarGraficoAssunto() {
        var ano = $('#ano_assunto').val();
        carregarGrafico(ano, 'grafico_assunto');
    }


</script>