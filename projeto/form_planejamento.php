<?php 
require_once 'actions/ManterPlanejamento.php';

$planejamentos = new ManterPlanejamento();
$planejamento = $planejamentos->listar();
?>

<div class="card mb-4 collapse hide border-primary" id="form_planejamento" style="max-width:800px">
    <div class="card-header py-2 card-body bg-gradient-primary align-middle">
        <span class="h6 m-0 font-weight text-white">Cadastro de planejamento</span>
    </div>
    <div class="card-body">
        <form action="save_planejamento.php" method="POST">
            <input type="hidden" name="id_planejamento" id="id">
            <div class="form-group row">
                <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
                <div class="col-sm-10 input-group">
                    <input type="text" name="nome" class="form-control form-control-sm" id="nome" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ano_inicio" class="col-sm-2 col-form-label">Ano Inicio:</label>
                <div class="col-sm-10 input-group">
                    <input type="number" name="ano_inicio" class="form-control form-control-sm" id="ano_inicio"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="ano_fim" class="col-sm-2 col-form-label">Ano Fim:</label>
                <div class="col-sm-10 input-group">
                    <input type="number" name="ano_fim" class="form-control form-control-sm" id="ano_fim" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="missao" class="col-sm-2 col-form-label">Missão:</label>
                <div class="col-sm-10 input-group">
                    <div style="width: 100%;">
                        <textarea class="form-control" id="froala-editor" name="missao" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="visao" class="col-sm-2 col-form-label">Visão:</label>
                <div class="col-sm-10 input-group" style="max-width: 800px;">
                    <div style="width: 100%;">
                        <textarea class="form-control" id="froala-editor-visao" name="visao" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row float-right">
                <button type="reset" onclick="$('#btn_cadastrar').show();" data-toggle="collapse"
                    data-target="#form_planejamento" class="btn btn-danger btn-sm"><i class="fa fa-minus-square"></i>
                    Cancelar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </form>

    </div>
</div>