<?php
require_once 'actions/ManterQuestPergunta.php';
require_once 'actions/ManterQuestResposta.php';
require_once 'dto/QuestResposta.php';
$manterQuestPergunta = new ManterQuestPergunta();
$manterQuestResposta = new ManterQuestResposta();

$perguntas = $manterQuestPergunta->listar();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_questionario = $_POST['id_questionario'];
    $id_quest_aplicacao = $_POST['id_quest_aplicacao'];
    $parametros = "?id=" . $id_questionario . "&aplicacao=" . $id_aplicacao;
    $r = new QuestResposta;
    
    $respostas_totais = [];
    foreach ($perguntas as $pergunta) {
        $nome_campo = "resposta_" . $pergunta->id;
        if (isset($_POST[$nome_campo])) {
            $resposta_quest = $_POST[$nome_campo];
            $respostas_totais[]     = $resposta;
            $r->id_quest_aplicacao  = $id_quest_aplicacao;
            $r->id_quest_pergunta   = $pergunta->id;
            $r->resposta            = $resposta_quest;
            $resultado = $manterQuestResposta->salvar($r);
        }
    }

    if($resultado) {
        header('Location: index.php');
        exit;
    }
}