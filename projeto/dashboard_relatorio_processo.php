<script>
    $.getJSON("obter_relatorio_processo.php", { ano: <?= $ano ?>, tipo: '<?= $tipo ?>' }, function (dados) { // chamada ajax para buscar os dados de acordo com id da pergunta
        
        const labels = [];
        const valores = [];
        dados.forEach(item => {
            labels.push(item.label);   // 👈 só texto
            valores.push(item.total);  // 👈 só número
        });
        datasets = [{
            label: 'Quantidade',
            data: valores
        }];
        
        // dinamismo para a geração de gráfico
        let rgb = window.crypto.getRandomValues(new Uint8Array(3)).reduce((acc, val) => acc + val.toString(16), "#"); // gera um hexadecimal aleatório
    
        // instanciação do gráfico de carregando de dados e condicionais
        const ctx = document.getElementById('grafico_<?= $tipo ?>').getContext('2d');
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
</script>