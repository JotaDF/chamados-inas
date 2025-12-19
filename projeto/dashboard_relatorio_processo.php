<script>
        function carregarGrafico(ano, campo = 'grafico_assunto') {
        $.getJSON(
            "obter_relatorio_processo.php",
            { ano: ano, tipo: campo },
            function (dados) {

                // destrói gráfico existente
                if (window[campo] instanceof Chart) {
                    window[campo].destroy();
                }

                const labels = [];
                const valores = [];

                dados.forEach(item => {
                    labels.push(item.label);
                    valores.push(item.total);
                });

                const datasets = [{
                    label: 'Quantidade de processos por Assunto - Sub_assunto',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }];

                const ctx = document.getElementById(campo).getContext('2d');

                // ✅ salva o gráfico no window[campo]
                window[campo] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        );
        }
    $(document).ready(function () {
        carregarGrafico('<?= $ano ?>', '<?= $tipo ?>');
    });
    function atualizarGrafico(tipo = 'assunto') {
        var campo = (tipo === 'assunto') ? 'grafico_assunto':'barra';
        var id_ano = (tipo === 'assunto') ? '#ano_assunto':'#ano';
        var ano = $(id_ano).val();
        carregarGrafico(ano, campo);
    }


</script>