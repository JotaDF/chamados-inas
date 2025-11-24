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
$processo->orgao_origem          = isset($_POST['orgao_origem']) ? $_POST['orgao_origem'] : '';
$processo->processo_vinculado       = isset($_POST['processo_vinculado']) ? $_POST['processo_vinculado'] : '';
$processo->guia                     = isset($_POST['guia']) ? $_POST['guia'] : '';
$processo->cpf                      = $_POST['cpf'];
$processo->beneficiario             = $_POST['beneficiario'];
$processo->assunto                  = $_POST['assunto'];
$processo->sub_assunto              = isset($_POST['sub_assunto']) ? $_POST['sub_assunto'] : 0;
$processo->motivo                   = isset($_POST['motivo']) ? $_POST['motivo'] : 0;
$processo->valor_causa              = isset($_POST['valor_causa']) ? $_POST['valor_causa'] : 0;
$processo->liminar                  = isset($_POST['liminar']) ? $_POST['liminar'] : '';
$processo->data_cumprimento_liminar = isset($_POST['data_cumprimento_liminar']) ? strtotime($_POST['data_cumprimento_liminar']) : '';
$processo->situacao_processual      = $_POST['situacao'];
$processo->observacao               = addslashes($_POST['observacoes']);
$processo->usuario                  = $_POST['usuario'];
$processo->pessoa_fisica            = isset($_POST['pessoa_fisica']) ? $_POST['pessoa_fisica'] : 0;


//print_r($processo);
$db_processo->salvar($processo); 

header('Location: processos.php');

