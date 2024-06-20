<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterProcesso.php');
require_once('./dto/Processo.php');

$db_processo = new ManterProcesso();
$processo = new Processo();

$id_principal                       = isset($_POST['id_principal']) ? $_POST['id_principal'] : 0;

$processo->id                       = isset($_POST['id']) ? $_POST['id'] : 0;
$processo->numero                   = isset($_POST['numero']) ? $_POST['numero'] : '';
$processo->autuacao                 = isset($_POST['autuacao']) ? strtotime($_POST['autuacao']) : '';
$processo->instancia                = isset($_POST['instancia']) ? $_POST['instancia'] : '';
$processo->sei                      = isset($_POST['sei']) ? $_POST['sei'] : '';
$processo->classe_judicial          = isset($_POST['classe_judicial']) ? $_POST['classe_judicial'] : '';
$processo->processo_principal       = isset($_POST['processo_principal']) ? $_POST['processo_principal'] : '';
$processo->guia                     = isset($_POST['guia']) ? $_POST['guia'] : '';
$processo->cpf                      = $_POST['cpf'];
$processo->beneficiario             = $_POST['beneficiario'];
$processo->assunto                  = $_POST['assunto'];
$processo->valor_causa              = isset($_POST['valor_causa']) ? $_POST['valor_causa'] : 0;
$processo->liminar                  = isset($_POST['liminar']) ? $_POST['liminar'] : '';
$processo->data_cumprimento_liminar = isset($_POST['data_cumprimento_liminar']) ? strtotime($_POST['data_cumprimento_liminar']) : '';
$processo->situacao_processual      = $_POST['situacao'];
$processo->observacoes              = addslashes($_POST['observacoes']);
$processo->usuario                  = $_POST['usuario'];


//print_r($processo);
$db_processo->salvar($processo);

header('Location: gerenciar_processos_vinculados.php?id=' . $id_principal);

