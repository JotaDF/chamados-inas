<style>
    button[disabled] {
        pointer-events: auto;
    }
</style>

<form action="gerador_xml.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="card-body ">
            <div class="row g-3">
                <div class="col">
                    <label for="formFile" class="form-label">Anexar Arquivo Excel</label>
                    <input class="form-control" type="file" name="excel" id="excel" accept=".xlsx, .xls, .xlt" required>
                </div>
                <div class="col">
                    <label for="retificacao1" class="form-label">Retificação</label>
                    <select class="form-select" name="reti" id="retificacao1" aria-label="Default select example">
                        <option selected></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>

            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="retificacao3" class="form-label">TPMB</label>
                    <select class="form-select" name="tpamb" id="retificacao3" aria-label="Default select example">
                        <option selected></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="col">
                    <div class="mb-2">
                        <label for="retificacao2" class="form-label">ProcEmi</label>
                        <select class="form-select" name="procEmi" id="retificacao2"
                            aria-label="Default select example">
                            <option selected></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="retificacao2" class="form-label">Natureza do Rendimento</label>
                        <select class="form-select" name="rend" id="retificacao2" aria-label="Default select example">
                            <option selected></option>
                            <option value="1">1705</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Periodo de Apuração</label>
                <input type="date" class="form-control" name="data">
            </div>
            <div class="mb-3">
                <!-- <button type="submit" name="envio" class="btn btn-primary btn-sm">Converter
                    XML</button>&nbsp&nbsp&nbsp -->
                <button type="submit" name="baixar" class="btn btn-secondary btn-sm" title="Gerar Xml" id="baixar" disabled>             
                    Baixar XML&nbsp&nbsp&nbsp<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6" />
                    </svg></button>
            </div>
            <script>
                document.getElementById('excel').addEventListener('change', function () {
                    const baixar = document.getElementById('baixar');
                    baixar.disabled = !this.files.length;

                });
            </script>
        </div>
     </div>
</form>
</div>
