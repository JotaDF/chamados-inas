<?php

require_once('./actions/ManterTarefa.php');
require_once('./dto/Tarefa.php');
require_once('./actions/ManterNotificacao.php');
require_once('./actions/ManterUsuario.php');
require_once('./dto/Notificacao.php');

$db_tarefa = new ManterTarefa();
$tarefa = new Tarefa();

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

// Registrando notificação
$db_notificacao = new ManterNotificacao();
$db_usuario = new ManterUsuario();
$n = new Notificacao();
$n->texto   = "Uma tarefa da sua equipe foi excluída!";
$n->link = 'tarefas.php?filtro=equipe';
$n->tipo = 'tarefa';

$listaParticipantes = $db_usuario->getUsuariosPorEquipe($db_tarefa->getTarefaPorId($id)->equipe);
foreach ($listaParticipantes as $obj) {
    $n->usuario = $obj->id;
    $db_notificacao->salvar($n);
}

if ($id > 0) {
    $db_tarefa->excluir($id);
    header('Location: tarefas.php');
} else {
    echo 'Falta de parâmetros!';
    header('Location: tarefas.php');
}
