<?php
require_once('actions/Model.php');
require_once('dto/InteracaoSolicitacao.php');

$manterInteracaoSolicitacao = new ManterInteracaoSolicitacao();

$parametro = $_POST['parametro'];

$id_solicitacao = isset($_POST['id_solicitacao']) ? $_POST['id_solicitacao'] : 0;

$chave = $_POST['chave'];

$i = new InteracaoSolicitacao();

$i->id = $id_solicitacao;
$i->chave = $chave;
$i->texto = $_POST['texto'];
$i->data = $_POST['data'];
$i->anexos = $_POST['anexos'];
$i->solicitacao = $_POST['solicitacao'];
$i->usuario = $_POST['usuario'];

$manterInteracaoSolicitacao->salvar($i);