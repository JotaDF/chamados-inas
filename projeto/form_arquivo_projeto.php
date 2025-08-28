
<form id="form_arquivo_projeto" method="POST" action="save_arquivo_projeto.php"  enctype="multipart/form-data">
    <input type="hidden" name="id_projeto" id="id_projeto" value="<?= $id_projeto ?>">
    <div class="container">
        <div class="card-body">
            <div class="row g-3">
                <div id="col">
                    <label for="formFile" class="form-label">Nome do Arquivo</label>
                    <input class="form-control form-control-sm" type="text" name="nome" id="nome" required>
                </div>
                <div id="col">
                    <label for="formFile" class="form-label">Anexar Arquivo do Projeto</label>
                    <input class="form-control form-control-sm" type="file" name="arquivo" id="arquivo" accept="" required>
                </div>
                <div id="conteudo">
                    <div id="texto">
                    </div>
                </div>
                <div class="mb-3" id="gif">
                    <button type="submit" id="envio" name="gif"
                        class="btn btn-primary btn-sm">Enviar Arquivo</button>
                </div>
            </div>
        </div>
    </div>
</form>
