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
                    <!-- Botão para enviar para o salva_csv.php -->
                    <button type="button" id="envio" class="btn btn-primary btn-sm" disabled>Enviar Arquivo</button>

                    <!-- Botão para enviar para o outro controller -->
                    <button type="button" id="atualiza" class="btn btn-primary btn-sm" disabled>Atualizar Situação SLA</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.getElementById('csv').addEventListener('change', function () {
        const atualizaButton = document.getElementById('envio');
        atualizaButton.disabled = !this.files.length; // Habilita o botão se tiver arquivos
    });
    document.getElementById('envio').addEventListener('click', function () {
        const form = document.getElementById('form_csv');
        form.action = "salva_csv.php"; // Alterando a ação do formulário
        form.submit(); // Enviando o formulário
    });
    document.getElementsById('atualiza').addEventListener('click', function () {
        form.action = "processa_prazo_regulacao.php"; // Alterando a ação do formulário para outro controller
        form.submit(); // Enviando o formulário
    });
</script>