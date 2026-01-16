<script>
    $.getJSON("obter_resposta_questionario.php", { id: <?= $pergunta->id ?> }, function (resposta) { // chamada ajax para buscar os dados de acordo com id da pergunta
        // passando valores do php para o javascript
        const escalas = <?= json_encode($escala) ?>;
        const parametro_resposta = <?= json_encode($parametros_resposta) ?>;
        const total_respostas_parametro = <?= json_encode($total_respostas_parametro) ?>;
        
        // pegando valores e chaves
        const numeros_respostas = Object.values(total_respostas_parametro);
        const nome_parametros = Object.keys(total_respostas_parametro);

        // dinamismo para a geração de gráfico
        let tipo_grafico = verificaParametro(parametro_resposta);
        let label_grafico = tipo_grafico != "bar" ? "" : "Respostas";
        let rgb = window.crypto.getRandomValues(new Uint8Array(3)).reduce((acc, val) => acc + val.toString(16), "#"); // gera um hexadecimal aleatório
        let backgroundColor = tipo_grafico != "pie" ? rgb : "";

        // instanciação do gráfico de carregando de dados e condicionais
        const ctx = document.getElementById('grafico_respostas' + <?= $pergunta->id ?>).getContext('2d');
        const dashboard = new Chart(ctx, {
            type: tipo_grafico,
            data: {
                labels: nome_parametros,
                datasets: [{
                    label: label_grafico,
                    data: numeros_respostas,
                    borderWidth: 1,
                }]
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