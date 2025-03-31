<script>
</script>
<form id="form_csv" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="update">
    <div class="container">
        <div class="card-body">
            <div class="row g-3">
                <div id="col">
                    <label for="formFile" class="form-label">Anexar Arquivo Excel</label>
                    <input class="form-control" type="file" name="csv" id="csv" accept=".csv" required>
                </div>
                <div id="conteudo">
                    <div id="texto">
                    </div>
                </div>
                <div class="mb-3" id="gif">
                    <button type="button" id="envio" name="gif" onclick="gifLoading()"
                        class="btn btn-primary btn-sm">Enviar Arquivo</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('csv').addEventListener('change', function () {
        const envioButton = document.getElementById('envio');
        envioButton.disabled = !this.files.length;
        if (this.files.length > 0) {
            atualizaButton.disabled = false;
        }
    });

    document.getElementById('envio').addEventListener('click', function () {
        const form = document.getElementById('form_csv');
        form.action = "salva_csv.php"; // Define o arquivo de processamento para salvar CSV
        form.submit(); // Envia o formulário

    });
    function gifLoading() {
        var div = document.getElementById("gif");

        div.style.display = 'none';
        let gif = document.createElement('img')
        gif.src = './img/loading_sla_regulacao.gif';
        gif.className = 'rounded mx-auto d-block';
        document.getElementById('conteudo').appendChild(gif)
        let carregamento = document.createElement('p')
        carregamento.id = 'texto';
        texto.innerText = 'Processando...';
    }
</script>