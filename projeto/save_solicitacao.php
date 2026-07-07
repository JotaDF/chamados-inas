<?php
require_once('actions/Model.php');
require_once('actions/ManterSolicitacao.php');
require_once('actions/ManterNotificacao.php');
require_once('actions/ManterUsuario.php');
require_once('dto/Solicitacao.php');

$manterSolicitacao = new ManterSolicitacao();

$setor = 'dijur';

$responsavel = 28;

$possuiAnexos = in_array(UPLOAD_ERR_OK, $_FILES['anexos']['error'], true); // verifica se foi feito upload de algum arquivo e retorna true ou false

$s = new Solicitacao();

$s->chave = $_POST['chave'];
$s->assunto = isset($_POST['assunto']) ? $_POST['assunto'] : '';
$s->setor = $_POST['setor'];
$s->responsavel = $responsavel;
$s->descricao = $_POST['descricao'];
$s->anexos = (int) $possuiAnexos;
$s->solicitante = $_POST['solicitante'];

$id_solicitacao = $manterSolicitacao->salvar($s);


$manterSolicitacao->processarSolicitacao($id_solicitacao, $possuiAnexos, $_FILES['anexos']);

// Registrando notificação
$manterNotificacao = new ManterNotificacao();

$manterUsuario = new ManterUsuario();

$lista_usuarios = $manterUsuario->getUsuariosPorIdSetor($responsavel);

$manterNotificacao->notificarNovaSolicitacao($responsavel);


header('Location: minhas_solicitacoes_dijur.php');