<form id="form_csv" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="update">
    <div class="container">
        <div class="card-body">
            <div class="row g-3">
                <div id="col">
                    <label for="formFile" class="form-label">Anexar Arquivo Excel</label>
                    <input class="form-control" type="file" name="csv" id="csv" accept=".csv" required>
                </div>
                <div class="mb-3">
                    <button type="button" id="envio" class="btn btn-primary btn-sm" disabled>Enviar Arquivo</button>
                    <button type="button" id="atualiza" class="btn btn-primary btn-sm" disabled>Atualizar Situação SLA</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('csv').addEventListener('change', function () {
        const envioButton = document.getElementById('envio');
        const atualizaButton = document.getElementById('atualiza');
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

    document.getElementById('atualiza').addEventListener('click', function () {
        const form = document.getElementById('form_csv');
        form.action = "processa_prazo_regulacao.php"; // Altera para a lógica de atualizar SLA
        form.submit(); // Envia o formulário
    });
</script>
