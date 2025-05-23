<?php
require_once 'actions/ManterQuestEscala.php';
require_once 'dto/QuestEscala.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id             = $_POST['id_quest_escala'];
    $nome           = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao      = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    
   
    if (!$nome || !$descricao) {
        header('Location: quest_escala.php?erro=1');
        exit;
    } 

    if (!$id) {
<<<<<<< HEAD
        header('Location: quest_escala.php?erro=2'); 
=======
        header('Location: quest_escala.php?naoveio'); 
>>>>>>> 9ce4742bbd7ca4223b4185e67a33a142db13d4ee
        exit;
    }

    if (trim($descricao) === '') {
        header('Location: quest_escala.php?msg=2');
        exit;
    }

    $escalaDTO                = new QuestEscala();
    $escalaDTO->id            = $id;
    $escalaDTO->nome          = $nome;
    $escalaDTO->descricao     = $descricao;

    $manterQuestEscala = new ManterQuestEscala;
    $resultado = $manterQuestEscala->salvar($escalaDTO);

    if($resultado) {
        header('Location: quest_escala.php?msg=1');
        exit;
    }
}