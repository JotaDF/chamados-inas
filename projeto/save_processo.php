<?php

date_default_timezone_set('America/Sao_Paulo');   
require_once('./actions/ManterProcesso.php');
require_once('./dto/Processo.php');

$db_processo = new ManterProcesso();
$processo = new Processo();

$processo->id                       = isset($_POST['id']) ? $_POST['id'] : 0;
$processo->numero                   = isset($_POST['numero']) ? $_POST['numero'] : '';
$processo->autuacao                 = isset($_POST['autuacao']) ? strtotime($_POST['autuacao']) : '';
$processo->instancia                = isset($_POST['instancia']) ? $_POST['instancia'] : '';
$processo->sei                      = isset($_POST['sei']) ? $_POST['sei'] : '';
$processo->classe_judicial          = isset($_POST['classe_judicial']) ? $_POST['classe_judicial'] : '';
$processo->processo_vinculado       = isset($_POST['processo_vinculado']) ? $_POST['processo_vinculado'] : '';
$processo->guia                     = isset($_POST['guia']) ? $_POST['guia'] : '';
$processo->cpf                      = $_POST['cpf'];
$processo->beneficiario             = $_POST['beneficiario'];
$processo->assunto                  = $_POST['assunto'];
$processo->valor_guia               = isset($_POST['valor_guia']) ? $_POST['valor_guia']  : 0;
$processo->valor_causa              = isset($_POST['valor_causa']) ? $_POST['valor_causa'] : 0;
$processo->deposito_judicial        = isset($_POST['deposito_judicial']) ? $_POST['deposito_judicial'] : 0;
$processo->reembolso                = isset($_POST['reembolso']) ? $_POST['reembolso'] : 0;
$processo->custas                   = isset($_POST['custas']) ? $_POST['custas'] : 0;
$processo->honorarios               = isset($_POST['honorarios']) ? $_POST['honorarios'] : 0;
$processo->danos_morais             = isset($_POST['danos_morais']) ? $_POST['danos_morais'] : 0;
$processo->liminar                  = isset($_POST['liminar']) ? $_POST['liminar'] : '';
$processo->data_cumprimento_liminar = isset($_POST['data_cumprimento_liminar']) ? strtotime($_POST['data_cumprimento_liminar']) : '';
$processo->situacao_processual      = $_POST['situacao'];
$processo->observacoes              = addslashes($_POST['observacoes']);
$processo->usuario                  = $_POST['usuario'];


//print_r($processo);
$db_processo->salvar($processo);

header('Location: processos.php');

