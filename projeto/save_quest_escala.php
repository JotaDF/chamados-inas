<?php
require_once 'actions/ManterQuestEscala.php';
require_once 'dto/QuestEscala.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id             = $_POST['id_quest_escala'];
    $nome           = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao      = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $parametro      = filter_input(INPUT_POST, 'parametro', FILTER_SANITIZE_SPECIAL_CHARS);  

    if (!$nome || !$descricao || !$parametro) {
        header('Location: quest_escala.php?erro=1');
        exit;
    }

    $escalaDTO                = new QuestEscala();
    $escalaDTO->id            = $id;
    $escalaDTO->nome          = $nome;
    $escalaDTO->descricao     = $descricao;
    $escalaDTO->parametro     = $parametro;
    $manterQuestEscala = new ManterQuestEscala;
    
    $resultado = $manterQuestEscala->salvar($escalaDTO);

    if($resultado) {
        header('Location: quest_escala.php?msg=1');
        exit;
    }
} 