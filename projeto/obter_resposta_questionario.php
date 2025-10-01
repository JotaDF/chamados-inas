<?php
require_once('./verifica_login.php');
require_once('actions/ManterQuestResposta.php');
header('Content-Type: application/json; charset=utf-8');
$id_pergunta = $_GET['id'];
$manterQuestResposta = new ManterQuestResposta();
$dados = $manterQuestResposta->getTodasRespostaPorPerguntaQuestionario($id_pergunta);
echo json_encode($dados);
